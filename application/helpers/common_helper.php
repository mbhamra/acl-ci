<?php
if(!function_exists('br')){
    /**
     * br function to print <br /> in html content 
     * 
     * @param type $i
     * @return string
     */
    function br($i=1){
        $content = '';
        do{
            $content .= '<br />';
            $i--;
        }while($i>0);
        
        return $content;
    }
}