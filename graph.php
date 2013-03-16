<?php
namespace graph {

    function load_graph($data) {
        $vs = $es =array();
        $e_i = 0;
        $e_uniq = array();
        foreach ($data as $id => $string) {
            $list = preg_split("/\s+/", trim($string));
            $v_i = array_shift($list);
            $vs[$v_i]['exp'] = 0;
            $vs[$v_i]['path'] = '';
            Foreach ($list as $v) {
                if (!isset($e_uniq[$v_i."_".$v]) && !isset($e_uniq[$v."_".$v_i])) {
                    $es[++$e_i] = array($v_i, $v);
                    $e_uniq[$v_i."_".$v] = $e_i;
                    $vs[$v_i]['edges'][$e_i] = 1;
                } else {
                    $vs[$v_i]['edges'][((isset($e_uniq[$v_i."_".$v])) ? $e_uniq[$v_i."_".$v] : $e_uniq[$v."_".$v_i])] = 1;
                }
            }
        }

        return array($vs, $es);
    }

    function load_directed_graph($data) {
        $vs = $es =array();
        $e_i = 0;
        $e_uniq = array();
        foreach ($data as $id => $string) {
            $list = preg_split("/\s+/", trim($string));
            $v_i = array_shift($list);
            $vs[$v_i]['exp'] = false;
            Foreach ($list as $v) {
                //if (!isset($e_uniq[$v_i."_".$v])) {
    //                $es[++$e_i] = array($v_i, $v);
    //                $e_uniq[$v_i."_".$v] = $e_i;
                    $vs[$v_i]['edges'][$e_i] = true;
    //                $vs[$v]['edges'][$e_i] = true;
                //}
            }
        }
        print($v_i);
        return array($vs, $es);
    }

    function minCut($v, $edges) {
        $cnt = count($v);

    $reset = 0;
        for ($i=1; $i<=$cnt - 2; $i++) {
            $edge = array_rand($edges);
    //print_r(array("Edge" => $edge, "Vert" => $edges[$edge]));
            $l_v = $edges[$edge][0];
            $r_v = $edges[$edge][1];

    //$start = microtime(true);
            foreach ($v[$r_v]['edges'] as $ed_id => $val) {
                if (isset($v[$l_v]['edges'][$ed_id])) {
                    unset($v[$l_v]['edges'][$ed_id]);
                    unset($edges[$ed_id]);
                } else {
                    $v[$l_v][$ed_id] = 1;
                    if ($edges[$ed_id][0] === $r_v){
                        $edges[$ed_id][0] = $l_v;
                    } else if ($edges[$ed_id][1] === $r_v){
                        $edges[$ed_id][1] = $l_v;
                    }
                }

            }
    //        unset($v[$r_v]);
        }
        return count($edges);
    }

    function bfs_explore(&$v, &$edges, $start) {
        $q = array();
        $v[$start]['exp'] = 1;
        $v[$start]['path'] = "$start";
        array_push($q, $start);

        while (count($q)) {

            $current = array_shift($q);

            foreach ($v[$current]['edges'] as $edge => $t) {
                $c_v = 0;
                $l = $edges[$edge][0];
                $r = $edges[$edge][1];
    //print_r(array($edge, $v[$l], $v[$r]));

                if ($v[$l]['exp'] && !$v[$r]['exp']){
                    $c_v = $r;
                }
                if ($v[$r]['exp'] && !$v[$l]['exp']){
                    $c_v = $l;
                }

                if ($c_v){
                    $v[$c_v]['exp'] = 1;
                    $v[$c_v]['path'] = $v[$current]['path'].":$c_v";
                    array_push($q, $c_v);
                }
            }
        }
    }

    function dfs_explore(&$v, &$edges, $start, $path) {
        $v[$start]['exp'] = 1;
        $v[$start]['path'] = $path.$start.":";

        foreach ($v[$start]['edges'] as $edge => $t) {
            $c_v = 0;

            $l = $edges[$edge][0];
            $r = $edges[$edge][1];

            if ($v[$l]['exp'] && !$v[$r]['exp']){
                $c_v = $r;
            }
            if ($v[$r]['exp'] && !$v[$l]['exp']){
                $c_v = $l;
            }

            if ($c_v){
                dfs_explore($v, $edges, $c_v, $v[$start]['path']);
            }
        }
    }

    function dfs_directed(&$v, &$edges, $start, $direction='f') {
        global $timelife, $map, $leader;

        $v[$start]['exp'] = true;
        $v[$start]['leader'] = $leader;
    //print_r("$start \n");
        foreach ($v[$start]['edges'] as $edge => $t) {
            $c_v = 0;

            $l = $edges[$edge][0];
            $r = $edges[$edge][1];

            if ($direction == 'f') {
                if ($v[$r]['exp'] != true){
                    $c_v = $r;
                }
            } else {
                if ($v[$l]['exp'] != true){
                    $c_v = $l;
                }
            }

            if ($c_v){
                dfs_directed($v, $edges, $c_v, $direction);
            }
        }
        $map[++$timelife] = $start;
    }
}

namespace graph\dijkstra {

    function load_graph_with_length($data) {
        $vs = $es =array();
        $e_i = 0;
        $e_uniq = array();
        foreach ($data as $id => $string) {
            $list = preg_split("/\s+/", trim($string));
            $v_i = (int)array_shift($list);
            $vs[$v_i] = 0;
            Foreach ($list as $v) {
                list($v, $dist) = explode(",", $v);
                if (!isset($e_uniq[$v_i."_".$v]) && !isset($e_uniq[$v."_".$v_i])) {
                    $es[++$e_i] = array("l" => $v_i, "r" => $v, "dist" => $dist);
                    $e_uniq[$v_i."_".$v] = $e_i;
                }
            }
        }

        return array($vs, $es);
    }

    function init($start, &$state) {
        $state['x'][$start] = 0;
        unset($state['v-x'][$start]);
        $state['len'][$start] = 0;
        $state['path'][$start] = "$start";
    }

    function move($ed, &$state) {
//print_r("MOVE ".$ed);
        if (isset($state['x'][$state['e'][$ed]['l']])){
            $from = $state['e'][$ed]['l'];
            $to = $state['e'][$ed]['r'];
        } else {
            $from = $state['e'][$ed]['r'];
            $to = $state['e'][$ed]['l'];
        }
        $state['x'][$to] = 0;
        unset($state['v-x'][$to]);

        $state['len'][$to] = $state['len'][$from] + $state['e'][$ed]['dist'];
        $state['path'][$to] = $state['path'][$from] . " -> $to";
        unset($state['e'][$ed]);
    }

    function crosses_frontier($ed, &$state) {
        if (
            isset($state['x'][$state['e'][$ed]['l']])
            &&
            isset($state['v-x'][$state['e'][$ed]['r']])
        ){
            return $state['len'][$state['e'][$ed]['l']] + $state['e'][$ed]['dist'];
        }
        if (
            isset($state['x'][$state['e'][$ed]['r']])
            &&
            isset($state['v-x'][$state['e'][$ed]['l']])
        ){
            return $state['len'][$state['e'][$ed]['r']] + $state['e'][$ed]['dist'];
        }
        return 0;
    }

}

?>
