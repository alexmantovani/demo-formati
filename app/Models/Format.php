<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\PseudoTypes\True_;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\returnSelf;

class Format extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hasParent()
    {
        return $this->parent_alias != "";
    }

    public function parent()
    {
        return Format::where('alias', $this->parent_alias)->first();
    }

    public function childs()
    {
        return $this->hasMany(Format::class, 'parent_alias', 'alias');
    }

    public function set_visible($visible, $step)
    {
        $value = $visible;
        if ($value) {
            $value = $this->respectRules();
        }
        if (!$value) {
            $step = 0;
        }

        // Andrebbero verificate le regole
        $this->update([
            'visible' => $value,
            'step' => $step,
        ]);
        return $this;
    }

    public function parseRule($rule)
    {
        if (strpos($rule, ">") !== false) {
            $pezzi = explode(">", $rule);
            $item = Format::where('alias', $pezzi[0])->first();
            return ($item->value > $pezzi[1]);
        } elseif (strpos($rule, "<") !== false) {
            $pezzi = explode("<", $rule);
            $item = Format::where('alias', $pezzi[0])->first();
            return ($item->value < $pezzi[1]);
        } elseif (strpos($rule, "!=") !== false) {
            $pezzi = explode("!=", $rule);
            $item = Format::where('alias', $pezzi[0])->first();
            return ($item->value != $pezzi[1]);
        } elseif (strpos($rule, "=") !== false) {
            $pezzi = explode("=", $rule);
            $item = Format::where('alias', $pezzi[0])->first();
            // print($pezzi[0]." ".$item->value."=".$pezzi[1]."<br>");
            return ($item->value == $pezzi[1]);
        } else {
            abort(403, "Regola non corretta (" . $rule . ").");
        }
    }

    public function respectRules()
    {
        // print($this->alias . " '" .$this->rules . "'<br>");
        if (is_null($this->parent())) {
            return true;
        }

        if ($this->rules == '') {
            // Non ho definito regole se non la dipendenza al parent
            $value = $this->parent()->value;

            if ($value == 'on') return true;
        } else {
            foreach (explode("&", $this->rules) as $rule) {
                // print($rule . " exploded<br>");
                if ( ! $this->parseRule($rule) ) {
                    return false;
                }
            }

            return true;
        }

        return false;



        // print($this->parent_alias."<br>");
        // if ($this->parent_alias == "GruppoColla") {
        //     dd($this->parent()->value);
        //     return false;
        // }

        // return true;
    }


    public function findItemsWithStep($step)
    {
        $items = Format::where('step', $step);

        return $items;
    }

    public function findItemsWithParents($parentArray)
    {
        $items = Format::whereIn('parent_alias', $parentArray)
            // ->get()
            // ->groupBy(['parent_alias'])
        ;

        return $items;
    }

    public function getVisibleItems()
    {
        $items = Format::where('visible', 1)
            ->get()
            ->groupBy(['parent_alias']);

        return $items;
    }

    public function updateAliasWithValue($alias, $value)
    {
        $format = Format::where('alias', $alias)->first();
        $format->update([
            'value' => $value,
        ]);
        return $format;
    }
}
