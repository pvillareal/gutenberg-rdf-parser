<?php

namespace Gutenberg\Parser;

use Imagick;
use ImagickDraw;

class CoverParser
{

    public function __invoke(Imagick $img) : void
    {
        $draw = new ImagickDraw();
        $draw->setFontSize(10);
        $draw->setFont('DejaVu-Sans-Bold');
        $str = 'The Golden Wheel Dream-book and Fortune-teller Being the most complete work on fortune-telling and interpreting dreams ever printed, containing an alphabetical list of dreams, with their interpretation, and the lucky numbers they signify. Also explaining how to tell fortunes by the mysterious golden wheel, with cards, dice, and dominoes. How to tell future events by the lines of the hands, by moles on the body, by the face, nails of the fingers, hair and shape of the head. How to find where to dig for water, coal, and all kinds of metals, by means of the celebrated divining or luck rod. How to tell the temper and disposition of anybody, how to tell fortunes with tea leaves and coffee grounds, signs of the Moon\'s age, lucky and unlucky days, together with charms to make your sweetheart love you, and to make a lover pop the question, with twenty ways of telling fortunes on New Year\'s eve, and a complete language and signification of the flowers.';
        if(strlen($str) > 120) {
            $words = explode(' ', $str);
            $lastWord = end($words);
            $charsLastWord = strlen($lastWord);
            $str = wordwrap($str, 120 - 7 - $charsLastWord); // -7 because we count the chars of " (...) "
            $str = explode("\n", $str, 2);
            $str = $str[0].'...'.$lastWord;
        }

        $str = wordwrap($str, 30,PHP_EOL);
        $str_array = explode(PHP_EOL, $str);
        $y = 20;
        foreach($str_array as $line) {
            $y = $y+12;
            $img->annotateImage( $draw, 10, $y, 0, $line);
        }

        $draw->setFont('DejaVu-Sans');
        $y = 68 + 24;
        $authors = ["De la Roche, Mazo",
            "Comer, Cornelia A. P. (Cornelia Atwood Pratt)",
            "Ashe, Elizabeth"
        ]; // limit to 3
        foreach($authors as $line) {
            $line = (strlen($line) > 30) ? substr($line,0,30).'...' : $line;
            $y += 11;
            $img->annotateImage( $draw, 10, $y, 0, $line);
        }
        $img->annotateImage( $draw, 10, 295, 0, "Project Guttenberg");
        $img->writeImage("./tmp/medium.cover.jpg");
        $img->cropThumbnailImage(66, 99);
        $img->writeImage("./tmp/small.cover.png");
    }

}