<?php
namespace Slimork\Providers\Pagination;

use Illuminate\Pagination\Paginator as SimplePaginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Paginator {

    protected $items;
    protected $per_page;
    protected $current_page = null;
    protected $options      = [];
    protected $total;

    public function items($items) {
        $this->items = $items;

        return $this;
    }

    public function perPage($per_page) {
        $this->per_page = $per_page;

        return $this;
    }

    public function currentPage($current_page) {
        $this->current_page = $current_page;

        return $this;
    }

    public function options($options) {
        $this->options = $options;

        return $this;
    }

    public function total($total) {
        $this->total = $total;

        return $this;
    }

    // Create default or simple pagiantor
    public function default() {
        return $this->createDefaultPaginator($this->items, $this->total, $this->per_page, $this->current_page, $this->options);
    }

    public function simple() {
        return $this->createSimplePaginator($this->items, $this->per_page, $this->current_page, $this->options);
    }

    // Initial default or simple paginator
    public function createDefaultPaginator($items, $total, $per_page, $current_page = null, array $options = []) {
        return new LengthAwarePaginator($items, $total, $per_page, $current_page, $options);
    }

    public function createSimplePaginator($items, $per_page, $current_page = null, array $options = []) {
        return new SimplePaginator($items, $per_page, $current_page, $options);
    }

    // Initial parent paginator default views and resolver
    public static function setDefaultTemplate($views) {
        SimplePaginator::defaultView($views['default']);
        SimplePaginator::defaultSimpleView($views['simple']);
    }

    public static function setDefaultResolver($viewFactory, $currentPath, $currentPage) {
        SimplePaginator::viewFactoryResolver(function() use ($viewFactory) {
            return $viewFactory;
        });

        SimplePaginator::currentPathResolver(function() use ($currentPath) {
            return $currentPath;
        });

        SimplePaginator::currentPageResolver(function() use ($currentPage) {
            return $currentPage;
        });
    }

}
