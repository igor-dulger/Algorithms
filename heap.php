<?php
class Heap {
    
    private $data;
            
    public function __construct($data = array()) {
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
        $i = count($this->data)-1;
        while ($i > 0 && $this->data[$i] < $this->data[$this->getParentPos($i)]) {
            $t = $this->data[$i];
            $this->data[$i] = $this->data[$this->getParentPos($i)];
            $this->data[$this->getParentPos($i)] = $t;
            $i = $this->getParentPos($i);
        }
    }
    
    public function __toString() {
        $result = '';
        $level = $i = 0;
        $prefix = str_repeat(" ", (count($this->data)+1)); 
        foreach ($this->data as $el){
            $i++;
            $result .= $prefix.$el;
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

$heap = new Heap($data);
print($heap);
?>
