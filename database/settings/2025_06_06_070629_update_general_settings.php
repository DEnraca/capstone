<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

use function GuzzleHttp\json_decode;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $colors = [
            "gray" => "rgb(18, 17, 17)",
            "info" => "rgb(255, 255, 255)",
            "danger" => "rgb(199, 29, 81)",
            "primary" => "rgb(250,177,47)",
            "success" => "rgb(12, 195, 178)",
            "warning" => "rgb(255, 186, 93)",
            "secondary" => "rgb(250,177,47)",
        ];
        $this->migrator->update('general.brand_name',fn(string $timezone) => 'ABR Diagnostic Center OPC' );
        $this->migrator->update('general.site_theme',fn() => $colors);
        $this->migrator->update('general.brand_logo',fn() => 'sites/01JR3EN20JVA69XS94NHKM3GS8.png' );
        $this->migrator->update('general.site_favicon',fn() => 'sites/01JR3EN20MV75VFZ527Z30204V.ico' );
    }
};
