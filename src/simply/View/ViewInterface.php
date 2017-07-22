<?php

namespace Simply\View;

interface ViewInterface {

    public function callViewRender(string $fileView, array $data = []);

}