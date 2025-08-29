<?php

namespace App\Livewire;

use App\Models\ModalidadDeportiva;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;

class ReporteModalidadInfolistComponent extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public int $id_deporte;
    public string $nombre_deporte;
    public bool $display = true;

    public function moutn($id_deporte, $nombre_deporte)
    {
        $this->id_deporte = $id_deporte;
        $this->nombre_deporte = $nombre_deporte;
    }


    public function render()
    {
        return view('livewire.reporte-modalidad-infolist-component');
    }

    public function deportesInfoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([
                'modalidades' => $this->getModalidades()->get()
            ])
            ->schema([
                Section::make($this->nombre_deporte)
                    ->description(function (): string {
                        $modalidades = $this->getModalidades();
                        return "Modalidades " . $modalidades->count();
                    })
                    ->headerActions([
                        Action::make('imprimir_deporte')
                            ->label('Generar PDF')
                    ])
                    ->schema([
                        RepeatableEntry::make('modalidades')
                            ->label('')
                            ->schema([
                                TextEntry::make('modalidad')
                                    ->label('')
                                    ->suffixAction(
                                        Action::make('ver_inscritos')
                                            ->label('Generar PDF')
                                            ->icon('heroicon-c-document-arrow-down')
                                    ),
                            ])
                    ])
                    ->compact()
                    ->collapsed(),
            ]);
    }

    protected function getModalidades(): \Illuminate\Database\Eloquent\Builder|\LaravelIdea\Helper\App\Models\_IH_ModalidadDeportiva_QB
    {
        $query = ModalidadDeportiva::query();
        $query->where('id_deporte', $this->id_deporte)
            ->where('puntuable', 1)
            ->where('en_practica', 1)
            ->orderBy('id_deporte');
        return $query;
    }

}
