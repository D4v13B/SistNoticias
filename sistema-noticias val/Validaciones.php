<?php
class Validacion {
    /**
     * Valida si un archivo es una imagen válida (JPG, JPEG o PNG)
     * 
     * @param array $archivo Array $_FILES del archivo
     * @return bool|string True si es válido, mensaje de error si no
     */
    public static function esImagenValida($archivo) {
        // Validar si se subió un archivo
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return 'Error al subir el archivo: ' . self::obtenerMensajeError($archivo['error']);
        }
        
        // Validar tipo MIME
        $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $archivo['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mime, $tiposPermitidos)) {
            return 'Solo se permiten imágenes en formato JPG o PNG';
        }
        
        // Validar tamaño máximo (2MB)
        $tamañoMaximo = 2 * 1024 * 1024; // 2MB
        if ($archivo['size'] > $tamañoMaximo) {
            return 'El tamaño máximo permitido es de 2MB';
        }
        
        return true;
    }
    
    /**
     * Obtiene un mensaje de error legible para errores de subida de archivos
     * 
     * @param int $errorCode Código de error de $_FILES['error']
     * @return string Mensaje de error
     */
    private static function obtenerMensajeError($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'El archivo es demasiado grande';
            case UPLOAD_ERR_PARTIAL:
                return 'El archivo fue subido parcialmente';
            case UPLOAD_ERR_NO_FILE:
                return 'No se subió ningún archivo';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'No se encontró el directorio temporal';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Error al escribir el archivo en el disco';
            case UPLOAD_ERR_EXTENSION:
                return 'Una extensión de PHP detuvo la subida del archivo';
            default:
                return 'Error desconocido';
        }
    }
    
    /**
     * Valida y sanitiza un campo de texto
     * 
     * @param string $texto Texto a validar
     * @param int $maxLongitud Máxima longitud permitida
     * @return bool|string Texto sanitizado o mensaje de error
     */
    public static function validarTexto($texto, $maxLongitud = 255) {
        $texto = trim($texto);
        
        if (empty($texto)) {
            return 'Este campo es obligatorio';
        }
        
        if (strlen($texto) > $maxLongitud) {
            return "El texto no puede exceder los $maxLongitud caracteres";
        }
        
        // Sanitizar para seguridad
        return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
    }
}
?>