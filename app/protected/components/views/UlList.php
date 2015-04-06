<?php

$html = '';
if (is_array($this->data)) {
    $html = '<ul>';
    foreach ($this->data as $a) {
        $html .= "<li>" . $a->{$this->fieldName} . "</li>";
    }
    $html .= '</ul>';
}

echo $html;

?>