<?php


namespace GevorgMelkumyan\Models;

/** @property array $mapping */
trait Exportable {

    public function mapping() {
        return $this->mapping;
    }
}
