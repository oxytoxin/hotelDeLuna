<x-back-office-layout>
  <div class="py-6">
    <div class="px-4 sm:px-6 flex justify-between items-center w-full md:px-0">
      <h1 class="text-2xl font-semibold text-gray-600 uppercase">REPORTS</h1>
      <div class="flex space-x-1 items-center border-b">
        <svg class="w-4 h-4 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none"
          viewBox="0 0 24 24">
          <path
            d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
          </path>
        </svg>
        <span class="text-gray-500 font-semibold">Guest</span>
      </div>
    </div>
    <div class="px-4 sm:px-6 md:px-0">
      <!-- Replace with your content -->
      <div class="py-4">
        <div class="h-96 rounded-lg  border-gray-200">
          <livewire:back-office.guest-report />
        </div>
      </div>
      <!-- /End replace -->
    </div>
  </div>
</x-back-office-layout>
