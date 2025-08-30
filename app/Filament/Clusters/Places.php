<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Places extends Cluster
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home-modern';
    protected static ?string $navigationLabel='العناوين والمراكز';
    protected static string | \UnitEnum | null $navigationGroup='اعدادات';

}
