<?php

namespace Gutenberg\Parser;

use Gutenberg\Models\BookCover;
use Gutenberg\Models\GutenbergBook;
use Imagick;
use ImagickDraw;

class CoverParser
{

    public function __construct()
    {
        
    }

    public function __invoke(Imagick $img, GutenbergBook $book) : void
    {
        $draw = new ImagickDraw();
        $draw->setFontSize(10);

        $bookCover = new BookCover($book);
//        $title = " Colour vision : Being the Tyndall Lectures delivered in 1894 at the Royal Institution";
//        $title = "TEST MULTIPLE ADDITIONAL: The Golden Wheel Dream-book and Fortune-teller Being the most complete work on fortune-telling and interpreting dreams ever printed, containing an alphabetical list of dreams, with their interpretation, and the lucky numbers they signify. Also explaining how to tell fortunes by the mysterious golden wheel, with cards, dice, and dominoes. How to tell future events by the lines of the hands, by moles on the body, by the face, nails of the fingers, hair and shape of the head. How to find where to dig for water, coal, and all kinds of metals, by means of the celebrated divining or luck rod. How to tell the temper and disposition of anybody, how to tell fortunes with tea leaves and coffee grounds, signs of the Moon's age, lucky and unlucky days, together with charms to make your sweetheart love you, and to make a lover pop the question, with twenty ways of telling fortunes on New Year's eve, and a complete language and signification of the flowers.";
//        $title = $book->title;
        $row = 32;
        if ($bookCover->hasSubtitle()) {
            $title = $bookCover->getTitle();
            $draw->setFont('DejaVu-Sans-Bold');
            $img->annotateImage($draw, 10, 32, 0, $title);

            $draw->setFont('DejaVu-Sans');
            $subTitle = $bookCover->getSubtitle();
            $str = wordwrap($subTitle, 30,PHP_EOL);
            $str_array = explode(PHP_EOL, $str);
            $y = $row;
            foreach($str_array as $line) {
                $y = $y+12;
                $img->annotateImage( $draw, 10, $y, 0, $line);
            }
        } else {
            $draw->setFont('DejaVu-Sans-Bold');
            $str = $bookCover->getTitle();
            $str = wordwrap($str, 30,PHP_EOL);
            $str_array = explode(PHP_EOL, $str);
            $y = $row;
            foreach($str_array as $line) {
                $img->annotateImage( $draw, 10, $y, 0, $line);
                $y = $y+12;
            }
        }



        $draw->setFont('DejaVu-Sans');
        $y = 68 + 24;
//        $authors = $book->getAuthors();
        $authors = [
            "De la Roche, Mazo",
            "Comer, Cornelia A. P. (Cornelia Atwood Pratt)",
            "Ashe, Elizabeth",
            "AuthorName Surname4",
            "AuthorName Surname5",
        ];
        $authorsDisplay = $bookCover->getAuthors();
//        foreach ($authors as $author) {
//            $authorsDisplay[] = (strlen($author) > 30) ? substr($author,0,30).'...' : $author;
//            if (count($authorsDisplay) === 3) {
//                break;
//            }
//        }
        foreach($authorsDisplay as $line) {
            $y += 11;
            $img->annotateImage( $draw, 10, $y, 0, $line);
        }
        $img->annotateImage( $draw, 10, 295, 0, "Project Guttenberg");
        $img->writeImage("./tmp/medium.cover.jpg");
        $img->cropThumbnailImage(66, 99);
        $img->writeImage("./tmp/small.cover.jpg");
    }

}