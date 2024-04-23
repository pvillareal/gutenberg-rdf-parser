<?php

namespace spec\Gutenberg\Models;

use Gutenberg\Models\BookCover;
use Gutenberg\Models\GutenbergBook;
use PhpSpec\ObjectBehavior;

class BookCoverSpec extends ObjectBehavior
{

    public function let(GutenbergBook $book)
    {
        $this->beConstructedWith($book);
        $book->getTitle()->willReturn(" Colour vision and other things : Being the Tyndall Lectures delivered in 1894 at the Royal Institution");
        $book->getAuthors()->willReturn([
            "De la Roche, Mazo",
            "Comer, Cornelia A. P. (Cornelia Atwood Pratt)",
            "Ashe, Elizabeth",
            "AuthorName Surname4",
            "AuthorName Surname5",
        ]);
    }
    function it_is_initializable(GutenbergBook $book)
    {
        $this->shouldHaveType(BookCover::class);
    }

    public function it_has_a_title(GutenbergBook $book)
    {
        $book->getTitle()->willReturn("The Golden Wheel Dream-book and Fortune-teller Being the most complete work on fortune-telling and interpreting dreams ever printed, containing an alphabetical list of dreams, with their interpretation, and the lucky numbers they signify. Also explaining how to tell fortunes by the mysterious golden wheel, with cards, dice, and dominoes. How to tell future events by the lines of the hands, by moles on the body, by the face, nails of the fingers, hair and shape of the head. How to find where to dig for water, coal, and all kinds of metals, by means of the celebrated divining or luck rod. How to tell the temper and disposition of anybody, how to tell fortunes with tea leaves and coffee grounds, signs of the Moon's age, lucky and unlucky days, together with charms to make your sweetheart love you, and to make a lover pop the question, with twenty ways of telling fortunes on New Year's eve, and a complete language and signification of the flowers.");
        $this->getTitle()->shouldReturn("The Golden Wheel Dream-book and Fortune-teller Being the most complete work on fortune-telling and interpreting dreams...");
        $this->getSubtitle()->shouldReturn("");
        $this->hasSubtitle()->shouldReturn(false);
    }

    public function it_has_a_subtitle(GutenbergBook $book)
    {
        $this->getTitle()->shouldReturn("Colour vision and other...");
        $this->getSubtitle()->shouldReturn("Being the Tyndall Lectures delivered in 1894 at the Royal Institution");
        $this->hasSubtitle()->shouldReturn(true);
    }

    public function it_has_authors(GutenbergBook $book)
    {
        $this->beConstructedWith($book);
        $book->getAuthors()->willReturn([
            "De la Roche, Mazo",
            "Comer, Cornelia A. P. (Cornelia Atwood Pratt)",
            "Ashe, Elizabeth",
            "AuthorName Surname4",
            "AuthorName Surname5",
        ]);
        $this->getAuthors()->shouldBeArray();
        $this->getAuthors()->shouldContain("De la Roche, Mazo");
        $this->getAuthors()->shouldContain("Comer, Cornelia A. P. (Corneli...");
        $this->getAuthors()->shouldContain("Ashe, Elizabeth");
    }

}
