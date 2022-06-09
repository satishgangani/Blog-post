<?php

use App\Models\Tag;

if(!function_exists('genArrayFromArray')){
    //Generates an array of random length from a given array.
    function genArrayFromArray($arr, $n, $col = "id") {
        $result = [];
        $len = count($arr);
        $taken = [];
        if ($n > $len){
            return [];
        }
        while ($n > 0) {
            $x = rand(0,$len-1);
            array_push($result, $arr[in_array($arr[$x], $taken) ? $taken[$x] : $x][$col]);
            $taken[$x] = in_array(--$len, $taken) ? $taken[$len] : $len;
            $n--;
        }
        return $result;
    }
}

if(!function_exists('lipsum')){
    //Demo Text Genereation
    function lipsum(){
        return "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque bibendum commodo erat, vel dapibus diam euismod ac. Pellentesque aliquam, lacus et fermentum elementum, leo enim vestibulum sem, nec dictum arcu risus ac ipsum. Donec vitae nisl risus. Morbi ac nulla non urna rutrum maximus. Nunc sodales, nunc sit amet pellentesque varius, massa metus lobortis felis, a tristique nisi urna a nibh. Curabitur nunc ex, semper eu lectus nec, egestas faucibus ipsum. Pellentesque venenatis urna semper lectus fringilla, nec porttitor libero ullamcorper. Vestibulum laoreet, lectus vel cursus luctus, est lorem lobortis nisi, non venenatis nulla massa sed lacus. Suspendisse potenti. Pellentesque interdum rhoncus dolor, quis sodales tortor. Suspendisse pulvinar ipsum vel eros rutrum ultrices. Proin finibus dolor id turpis rhoncus, et mollis diam rutrum. Pellentesque tristique dignissim interdum. Fusce vel metus ut nisi rhoncus imperdiet.Aliquam dignissim consequat malesuada. Praesent sagittis volutpat mattis. Sed euismod dictum risus. Nulla facilisi. In ullamcorper risus ac pellentesque aliquam. Praesent ac mi tincidunt neque aliquam cursus sed suscipit mauris. Suspendisse vel libero nec diam blandit facilisis. Donec sed fringilla urna. Aenean molestie, tortor vel pharetra tempus, dolor lorem feugiat felis, maximus efficitur risus ipsum quis eros.Maecenas felis mi, gravida id purus quis, vehicula tempor elit. Pellentesque nulla est, ullamcorper non tortor at, euismod condimentum nulla. Nulla iaculis auctor lectus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Praesent urna justo, blandit sed neque ut, dapibus eleifend orci. Aenean ut vestibulum tortor. Phasellus eu magna augue. Vivamus sollicitudin, orci id condimentum tristique, odio justo blandit tortor, porta tincidunt orci dolor euismod ante. Aliquam urna metus, eleifend eget rhoncus quis, tempus nec lectus. Ut dictum sed augue id ullamcorper. Suspendisse nibh purus, porta eget quam eu, vehicula iaculis risus. Donec mi erat, egestas ut urna aliquam, iaculis dignissim nunc. Praesent non mi elementum, fermentum felis vitae, consectetur nibh. Suspendisse tempor arcu eget ex efficitur molestie. Nunc vel scelerisque dolor.Donec at volutpat ante. Donec sollicitudin, sem in scelerisque ultrices, ante tellus fermentum purus, id posuere justo velit vel purus. Nulla sit amet mi id sem suscipit tempor fringilla ac urna. Curabitur non faucibus augue, ac blandit tellus. In at viverra ex. Vivamus aliquam malesuada finibus. Aenean commodo orci elit, in ornare libero lobortis ac. Suspendisse commodo tellus luctus, facilisis justo placerat, tincidunt urna. Nulla dignissim tempus urna ac egestas. Pellentesque ac dui dictum, commodo leo quis, molestie nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ut posuere felis.Cras venenatis libero id lobortis tincidunt. Mauris sit amet purus porttitor, finibus enim sed, elementum enim. In a luctus ex. Praesent nec nisi mauris. Donec vel ipsum non tellus aliquam accumsan vitae porta enim. Nam gravida nec urna eget tristique. Donec aliquet lobortis imperdiet. Integer erat nunc, pretium sed est id, consequat interdum nulla. Vestibulum vitae sem est. Vestibulum erat justo, efficitur ac justo ac, laoreet mollis lorem.";
    }
}

if(!function_exists('short_string')){
    //Creates a short string from string passed of mentioned length and adds a suffix if provided.
    function short_string($str, $len = 150, $suffix = '')
    {
        $span = '...'.'<span class="desc-suffix">'.ucwords($suffix).'</span>';
        if(strlen($str) <= $len){
            $span = '';
        }
        return substr($str, 0, $len - 3) . $span;
    }
}

if(!function_exists('getTagName')){
    //Gets tag name from id.
    function getTagName($tag)
    {
        return Tag::where('id', $tag)->first()->title;
    }
}