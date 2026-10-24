<?php


function render_view($template, $data = [])
{
    $content = file_get_contents(VIEW_FOLDER . $template . '.view');
    foreach ($data as $key => $value) {
        $content = str_replace('{{' . $key . '}}', $value, $content);
    }
    $content = preg_replace('/{{\w+}}/', '', $content);
    echo $content;
}
