<?php

class Navigation
{
    public static function genererMenuHtml($elements, $pageCourante)
    {
        if( is_array($elements) ) {
            $html = '<ul>';
            foreach( $elements as $element ) {
                // $html .= '<li><a href="' . $element['lien'] . '">' . $element['nom'] . '</a></li>';
                if( $element['lien'] == $pageCourante ) {
                    $html .= sprintf('<li>%s</li>', $element['nom']);
                }
                else {
                    $html .= sprintf('<li><a href="%s">%s</a></li>', $element['lien'], $element['nom']);
                }
                
            }
            $html .= '</ul>';

            return $html;
        }
        else {
            throw new Exception("Impossible de générer le menu en HTML");
        }
    }
}