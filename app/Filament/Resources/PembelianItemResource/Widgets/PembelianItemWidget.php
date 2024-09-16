<?php

namespace App\Filament\Resources\PembelianItemResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\PembelianItem;
use Filament\Actions\DeleteAction;
// use Filament\Actions\EditAction;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
// use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Summarizer;

class PembelianItemWidget extends BaseWidget
{
   public $pembelianId;

   public function mount($record)
   {
     $this->pembelianId = $record;
   }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                PembelianItem::query()->where('pembelian_id', $this->pembelianId),
            )
            ->columns([
                TextColumn::make('barang.nama')->label('nama barang'),
                TextColumn::make('jumlah')->label('jumlah barang'),
                TextColumn::make('harga')->label('harga barang'),
                TextColumn::make('total')->label('Total harga')
                ->getStateUsing(function ($record)  {
                    return $record->jumlah * $record->harga;
                })
                ->money('IDR')
                ->summarize(
                    Summarizer::make()
                    ->using(function($query) {
                        return $query->sum(DB::raw('jumlah * harga'));
                    })->money('IDR'),
                ),
            ])->actions([
                Tables\Actions\EditAction::make()
                ->form([
                    TextInput::make('jumlah')->required(),
                ]),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}