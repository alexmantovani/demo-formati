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

    public function set_visible($visible)
    {
        $value = $visible;
        if ($value) {
            $value = $this->respectRules();
        }

        // Andrebbero verificate le regole
        $this->update([
            'visible' => $value,
        ]);
        return $this;
    }

    public function parseRule($rule)
    {
        if (strpos($rule, ">=") !== false) {
            $pezzi = explode(">=", $rule);
            $item = Format::where('alias', $pezzi[0])->first();
            return ($item->value >= $pezzi[1]);
        } elseif (strpos($rule, ">") !== false) {
            $pezzi = explode(">", $rule);
            $item = Format::where('alias', $pezzi[0])->first();
            return ($item->value > $pezzi[1]);
        } elseif (strpos($rule, "<=") !== false) {
            $pezzi = explode("<=", $rule);
            $item = Format::where('alias', $pezzi[0])->first();
            return ($item->value <= $pezzi[1]);
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
        // Se l'elemento non appartiene a nessuno allo direi che la regole è sempre rispettata
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
                if (!$this->parseRule($rule)) {
                    return false;
                }
            }

            return true;
        }

        return false;
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
            ->groupBy(['group_title']);

        return $items;
    }


    public function getStepTree()
    {
        $items = Format::where('step', '>', 0)
            ->get()
            ->groupBy(['step', 'group_title']);

        return $items;
    }

    public function hideAllItems()
    {
        Format::where('visible', '=', 1)->update(['visible' => 0]);
    }

    public function updateAliasWithValue($alias, $value)
    {
        $format = Format::where('alias', $alias)->first();
        $format->update([
            'value' => $value,
        ]);
        return $format;
    }

    public function completeGroupTitle()
    {
        $items = Format::where('group_title', '')
            ->where('parent_alias', '!=', '')
            ->get();

        foreach ($items as $item) {
            $item->update(['group_title' => $item->parent()->name]);
        }
    }

    public function generateStepSequence()
    {
        Format::where('step', '>', 0)
            ->update(['step' => 0]);

        $step = 1;
        $elenco = [''];
        while (True) {
            // Cerco tutti gli elementi appartenenti all'elenco passatomi
            $items = Format::findItemsWithParents($elenco)->get();

            // Assegno quelli che rispettano le regole
            foreach ($items as $item) {
                $respectRules = $item->respectRules();
                $item->update([
                    'step' => $respectRules ? $step : 0,
                ]);
            }

            $items = Format::where('step', $step)->get();
            $elenco = $items->pluck('alias');
            if (count($elenco) == 0) break;

            $step = $step + 1;
        }
    }

    public function getStepIndex()
    {
    }


    public function generateCategories($items)
    {
        foreach ($items as $item) {
            // echo '<li>' . $item->name . '</li>';
            if (count($item->childs) > 0) {
                echo '<li><a href="' . $item->alias . '">' . $item->name . '</a></li>';
                echo '<ul>';
                // echo '<li>';
                Format::generateCategories($item->childs);
                // echo '</li>';
                echo '</ul>';
            }
        }
    }
}
