<?php
namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Note;
use PHPUnit\Framework\TestCase;

class NoteTest extends TestCase
{

    public function testConstruct()
    {
        $note = new Note();
        $this->assertNotNull($note->getCreatedAt());

        $now = new \DateTime();
        $this->assertEquals($note->getCreatedAt()->format('Y-m-d'), $now->format('Y-m-d'));
    }
}