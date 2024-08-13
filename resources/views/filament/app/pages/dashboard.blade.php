<x-filament-panels::page>
    <div class="py-4">
        <img src="{{ asset('img/teste-de-personalidade1.png') }}" alt="Vagas" class="">
    </div>
    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="$this->getWidgetData()"
        :widgets="$this->getVisibleWidgets()"
    />
</x-filament-panels::page>
