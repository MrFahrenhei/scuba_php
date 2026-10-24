<?php

namespace ScubaPHP;

class View
{
    public function __construct(private string $folder)
    {
    }

    public function fetch(string $template, array $data = []): string
    {
        $content = file_get_contents($this->folder . $template . '.view');
        foreach ($data as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }

        return preg_replace('/{{\w+}}/', '', $content);
    }

    public function render(string $template, array $data = []): void
    {
        echo $this->fetch($template, $data);
    }
}
