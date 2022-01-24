<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use App\Models\Format;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FormatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_parent()
    {
        $item_padre = Format::create([
            "alias" => "Velocita",
            "parent_alias" => "",
            "name" => "Velocità",
            "type" => "int",
        ]);
        $item_figlio = Format::create([
            "alias" => "CorrVel",
            "parent_alias" => "Velocita",
            "name" => "Correttivo Velocità",
            "type" => "int",
        ]);

        $this->assertNull($item_padre->parent());
        $this->assertEquals($item_figlio->parent()->name, 'Velocità');

        $this->assertFalse($item_padre->hasParent());
        $this->assertTrue($item_figlio->hasParent());
    }

    public function test_childs()
    {
        $item_padre = Format::create([
            "alias" => "Velocita",
            "parent_alias" => "",
            "name" => "Velocità",
            "type" => "int",
        ]);
        $item_figlio = Format::create([
            "alias" => "CorrVel",
            "parent_alias" => "Velocita",
            "name" => "Correttivo Velocità",
            "type" => "int",
        ]);
        $item_figlio = Format::create([
            "alias" => "VelJog",
            "parent_alias" => "Velocita",
            "name" => "Velocità con Jog",
            "type" => "int",
        ]);

        $this->assertEquals(count($item_padre->childs()->get()), 2);
        $this->assertEquals($item_padre->childs()->first()->alias, "CorrVel");
        $this->assertEquals(count($item_figlio->childs()->get()), 0);
    }


    public function test_visible()
    {
        $item_padre = Format::create([
            "alias" => "Velocita",
            "parent_alias" => "",
            "name" => "Velocità",
            "type" => "int",
        ]);

        $item = Format::find(1);
        $this->assertEquals($item->visible, 0);

        $item->set_visible(true, 1);
        $this->assertEquals($item->visible, 1);

        $item->set_visible(false, 1);
        $this->assertEquals($item->visible, 0);
    }

    // public function test_start()
    // {
    //     $item_padre = Format::create([
    //         "alias" => "Velocita",
    //         "parent_alias" => "",
    //         "name" => "Velocità",
    //         "type" => "int",
    //     ]);
    //     $item_figlio = Format::create([
    //         "alias" => "CorrVel",
    //         "parent_alias" => "Velocita",
    //         "name" => "Correttivo Velocità",
    //         "type" => "int",
    //     ]);
    //     Format::create([
    //         "alias" => "VelJog",
    //         "parent_alias" => "Velocita",
    //         "name" => "Velocità con Jog",
    //         "type" => "int",
    //     ]);

    //     $items = Format::findItemsWithParents(['']);
    //     $this->assertEquals(count($items->get()), 1);

    //     $items = Format::findItemsWithParents(['','Velocita']);
    //     $this->assertEquals(count($items->get()), 2);
        
    //     $items = Format::findItemsWithParents(['Velocita']);
    //     $this->assertEquals(count($items->get()), 1);
    // }
}
