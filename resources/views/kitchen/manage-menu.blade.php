<x-kitchen-layout>
    <div class=" h-screen ml-28 p-10">
       @livewire('kitchen.manage-menu',[
        $id = request()->id,
       ])
       </div>
</x-kitchen-layout>