<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionMethod;

trait ModuleResolver
{
    private function resolver()
    {
        $controllersPath = app_path('Http/Controllers');
        $namespace = 'App\\Http\\Controllers';

        return array_values(collect($this->methodFinder($this->fileFinder($controllersPath, $namespace)))->sortBy('name')->toArray());
    }

    protected function fileFinder($controllersPath, $namespace)
    {
        $controllers = [];

        foreach (File::allFiles($controllersPath) as $file) {
            $class = $namespace . '\\' . str_replace(
                ['/', '.php'],
                ['\\', ''],
                $file->getRelativePathname()
            );

            if (class_exists($class)) {
                $controllers[] = $class;
            }
        }

        return $controllers;
    }

    protected function methodFinder($controllers)
    {
        $results = [];
        $routes = array_values(array_filter(collect(Route::getRoutes())->toArray(), function ($route) {
            return isset($route->action['namespace']) && $route->action['namespace'] === 'mustValidate';
        }));

        foreach ($routes as $route) {
            if ($route->action['controller']) {
                [$file_path, $methodName] = explode('@', $route->action['controller']);
                $reflection = new ReflectionClass($file_path);
                $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
                if ($methods) {
                    $parts = explode('.', $route->action['as']);
                    $menu_module = null;
                    $name = $parts[0];
                    if (count($parts) > 1) {
                        $menu_module = array_shift($parts);
                        $name = array_shift($parts);
                    }
                    $translate_name = trans('menus.' . str($name)->snake('_')->lower());
                    $description = trans('menus.' . str($name)->snake('_')->lower() . '_desc');
                    $key = ($menu_module ?? 'parent') . ':' . $name;
                    $results[$key] = [
                        'name' => $translate_name,
                        'unique' => md5($translate_name),
                        'module' => $menu_module,
                        'description' => $description,
                        'state' => (true) ? true : false,
                    ];
                    foreach ($methods as $index => $method) {
                        if ($method->getDeclaringClass()->getName() !== $file_path) {
                            continue;
                        }
                        if (str_starts_with($method->getName(), '__')) {
                            continue;
                        }
                        $results[$key]['route'][$index] = [
                            'route_as' => $menu_module . '.' . $name . '.' . $method->getName(),
                            'method' => $method->getName(),
                            'name' => __('menus.' . $method->getName()),
                            'desc' => __('menus.' . $method->getName() . '_desc') . ' ' . str($results[$key]['name'])->lower(),
                        ];
                    }
                }
            }
        }
        $results = array_filter($results, function ($result) {
            return isset($result['route']);
        });
        $module = $this->parentModuleSolver($results);
        $results = array_merge($module, array_values($results));
        $results = arrayTree($results, 'module', 'name');
        return $results;
    }

    private function parentModuleSolver($menus)
    {
        $results = array_map(function ($menu) {
            return $menu['module'];
        }, $menus);
        $temps = removeDuplicate($results);
        $results = [];
        foreach ($temps as $value) {
            $results[] = [
                'unique' => md5($value),
                'name' => $value,
                'description' => $value,
                'module' => null,
                'state' => (true) ? true : false,
            ];
        }

        return $results;
    }
}
