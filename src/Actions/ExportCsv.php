<?php

namespace GevorgMelkumyan\Actions;

use GevorgMelkumyan\Models\Exportable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ExportCsv extends Action {
    use InteractsWithQueue, Queueable;

    public $name = 'Export CSV';

    protected $path = null;

    public function __construct(string $path, string $name = 'Export CSV') {
        $this->name = $name;
        $this->path = $path;
    }

    public function handle(ActionFields $fields, Collection $models) {

        $fileName = "{$models->first()->getTable()}-" . now()->format('Y-m-d-H-i-s') . '.csv';

        $path = "$this->path/$fileName";

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $out = fopen($path, 'w');

        $header = array_values($models->first()->mapping());

        fputcsv($out, $header);

        /** @var Exportable $model */
        foreach ($models as $model) {

            $data = [];

            foreach ($model->mapping() as $field => $value) {
                $data[] = $model->$field;
            }

            fputcsv($out, $data);
        }

        fclose($out);

        return Action::download(url($path), $fileName);
    }
}
