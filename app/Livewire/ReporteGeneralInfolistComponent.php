<?php

namespace App\Livewire;

use App\Models\Participante;
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

    public string $title = 'Listado General de Inscritos';
    public int $id_deporte = 0;
    public bool $cerrado = false;
    public string $texto = 'general';

    public function mount(string $title = '', int $id_deporte = 0)
    {
        if (!empty($title)) {
            $this->title = $title;
        }
        if ($id_deporte) {
            $this->id_deporte = $id_deporte;
            $this->cerrado = true;
            $this->texto = 'deporte' . $id_deporte;
        }
    }


    public function render()
    {
        return view('livewire.reporte-general-infolist-component');
    }

    public function reportesInfoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->state([])
            ->schema([
                Section::make($this->title)
                    ->description(fn(): string => 'Inscritos ' . cerosIzquierda($this->getInscritos()))
                    ->schema([
                        Livewire::make(ReporteGeneralTableComponent::class, [
                            'filtrar_entidad' => $this->filtrarEntidad(),
                            'id_entidad' => auth()->user()->id_entidad ?? 0,
                            'id_deporte' => $this->id_deporte,
                            'texto' => $this->texto
                        ]),
                    ])
                    ->headerActions([
                        Action::make('imprimir')
                            ->label('Generar PDF')
                            ->url(function ():string{
                                $response = route('export.reportes');
                                if ($this->id_deporte){
                                    $response = route('export.reportes', $this->id_deporte);
                                }
                                return  $response;
                            })
                            ->openUrlInNewTab()
                            ->hidden(!$this->getInscritos())
                            ->disabled(!$this->getInscritos())
                    ])
                    ->compact()
                    ->collapsed($this->cerrado),
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

    protected function getInscritos(): int
    {
        $participantes = Participante::query();
        if ($this->id_deporte) {
            $participantes->where('deporteini', $this->id_deporte);
        }
        $id_nivel = auth()->user()->id_nivel;
        $id_entidad = auth()->user()->id_entidad;
        $is_root = auth()->user()->is_root;
        if ($id_nivel != 1 && !$is_root) {
            $participantes->where('id_entidad', $id_entidad);
        }
        return $participantes->count();
    }

}
