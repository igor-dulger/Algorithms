<?php
namespace Heap {
class Heap {
    
    private $data = array();
    private $type = 'int';
    private $weight = 'weight';
    private $direction = 'min';
            
    public function __construct($data = array(), $direction = 'min', $type = 'int', $weight = 'weight') {
        if (!in_array($type, array("int", "object"))) die("Invalid type [$type]");
        $this->type = $type;
        $this->weight = $weight;
        $this->direction = $direction;
        foreach ($data as $el){
            $this->insert($el);
        }
    }
    
    private function getParentPos($i) {
        return floor($i/2);
    }
    
    private function getChildrenPos($i) {
        return array($i*2, $i*2+1);
    }
    
    public function insert($el) {
        $this->data[] = $el;
        $this->up(count($this->data)-1);
    }
    
    public function extractTop() {
        $result = array_shift($this->data);
        $last = array_pop($this->data);
        array_unshift($this->data, $last);
        $this->down(0);
        return $result;
    }
    
    public function getTop() {
        return $this->data[0];
    }
    
    public function getSize() {
        return count($this->data);
    }
    
    private function swap($l, $r) {
        $t = $this->data[$l];
        $this->data[$l] = $this->data[$r];
        $this->data[$r] = $t;
    }
    
    private function up($i) {
        while ($i > 0 && $this->cmp($i, $this->getParentPos($i)) == 1) {
            $this->swap($i, $this->getParentPos($i));
            $i = $this->getParentPos($i);
        }
    }
    
    private function cmp($l, $r) {
        if ($this->type == 'int') {
            $l_v = $this->data[$l];
            $r_v = $this->data[$r];
        } else if($this->type == 'object') {
            $l_v = $this->data[$l]->{$this->weight};
            $r_v = $this->data[$r]->{$this->weight};
        } 
        
        if ($l_v < $r_v) {
            return ($this->direction == 'min') ? 1 : -1;
        } else if ($l_v > $r_v) {
            return ($this->direction == 'min') ? -1 : 1;
        } else {
            return 0;
        }
    }
    
    private function down($i) {
        list($l, $r) = $this->getChildrenPos($i);
        if (
           isset($this->data[$l]) && $this->cmp($l,$i) == 1
           || 
           isset($this->data[$r]) && $this->cmp($r,$i) == 1
           ) {
            if(isset($this->data[$r])) {
                $t_i = ($this->cmp($l, $r) == 1) ? $l : $r;
            } else if(isset($this->data[$l])){
                $t_i = $l;
            } 
            
            $this->swap($i, $t_i);
            $this->down($t_i);
        }
    }
    
    public function __toString() {
        $result = '';
        $level = $i = 0;
        $prefix = str_repeat(" ", (count($this->data)+1)); 
        foreach ($this->data as $el){
            $i++;
            $result .= $prefix.($this->type == 'int' ? $el : $el->{$this->weight});
            if ($i == pow(2, $level)){
                $level++;
                $prefix = str_repeat("-", floor((count($this->data)+1)*2/(pow(2, $level)+1)) ); 
                
                $i = 0;
                $result .= "\n";
            }
        }
        return $result;
    }
}
}
//foreach ($data as $id) {
//$v =  new stdClass();
//    $v->id = $id +2;
//    $v->w = $id;
//    $d[] = $v;
//}
?>
