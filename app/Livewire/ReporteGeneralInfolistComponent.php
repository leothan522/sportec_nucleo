<?php

namespace App\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;
use function Symfony\Component\Translation\t;

class ReporteGeneralInfolistComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;


    public function render()
    {
        return view('livewire.reporte-general-infolist-component');
    }

    public function reportesInfoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([])
            ->schema([
                Section::make('Listado General de Inscritos')
                    ->schema([
                        Livewire::make(ReporteGeneralTableComponent::class, [
                            'filtrar_entidad' => $this->filtrarEntidad(),
                            'id_entidad' => auth()->user()->id_entidad ?? 0
                        ]),
                    ])
                    ->headerActions([
                        Action::make('imprimir')
                            ->label('Generar PDF')
                            ->url(route('web.index'))
                            ->openUrlInNewTab()
                    ])
                ->compact(),
            ]);
    }

    protected function filtrarEntidad(): bool
    {
        $response = false;
        $id_nivel = auth()->user()->id_nivel;
        $is_root = auth()->user()->is_root;
        if ($id_nivel != 1 && !$is_root) {
            $response = true;
        }
        return $response;
    }

}
