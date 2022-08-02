<?php

namespace App\Tests\Twig;

use PHPUnit\Framework\TestCase;
use App\Twig\SluggExtension;

class SluggExtensionTest extends TestCase
{
    /**
    * @dataProvider getSlugg
    */
    public function testSlugg(string $test, string $slugg): void
    {
        $sluggNew = new SluggExtension;
        $this->assertSame($slugg, $sluggNew->doSlugg($test));
    
    }

    public function getSlugg()
    {
        return [
            ['Test Text', 'test-text'],
            ['Test Text+', 'test-text'],
            ['Test Text!', 'test-text'],
            ['Test T/ext', 'test-text'],
            ['Test-Text', 'test-text'],
            ['Test \'Text', 'test-text'],
            ['Test ?Text', 'test-text'],
            ['Test %Text', 'test-text'],
        ];
    }
}
