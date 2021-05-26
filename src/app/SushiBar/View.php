<?php


namespace SushiBar;


class View
{

    /** @var array $viewContext */
    private $viewContext;

    public function __construct(array $viewContext = []) {
        $this->viewContext = $viewContext;
    }

    public function render(string $filename): void {
        /** @psalm-suppress UnresolvableInclude */
        require($filename);
    }

    /** @psalm-suppress MissingReturnType */
    public function get(string $key){
        return $this->viewContext[$key];
    }

}