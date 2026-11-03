<?php

namespace App\Common;

class Util
{
    /**
     * Devuelve un saludo simple.
     */
    public static function saludar(): string
    {
        return 'Hola Symfony';
    }

    public static function slugify(string $texto): string
    {
        $texto = iconv('UTF-8', 'ASCII//TRANSLIT', $texto);
        $texto = strtolower($texto);
        $texto = preg_replace('/[^a-z0-9]+/', '-', $texto);

        return trim($texto, '-');
    }
    /**
     * Convierte un texto a mayúsculas.
     */
    public static function convertirMayusculas(string $texto): string
    {
        return mb_strtoupper($texto);
    }

    /**
     * Formatea una fecha al formato día/mes/año.
     */
    public static function formatearFecha(\DateTimeInterface $fecha): string
    {
        return $fecha->format('d/m/Y');
    }

    /**
     * Genera una cadena aleatoria.
     */
    public static function generarCadena(int $longitud = 10): string
    {
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $resultado = '';

        for ($i = 0; $i < $longitud; $i++) {
            $resultado .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }

        return $resultado;
    }

    /**
     * Comprueba si un texto está vacío.
     */
    public static function estaVacio(?string $texto): bool
    {
        return $texto === null || trim($texto) === '';
    }
}
