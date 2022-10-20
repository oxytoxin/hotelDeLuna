<x-back-office-layout>
  <div class="py-6">
    <div class="px-4 sm:px-6 md:px-0">
      <h1 class="text-2xl font-semibold text-gray-600 uppercase">Reports</h1>
    </div>
    <div class="px-4 sm:px-6 md:px-0">
      <!-- Replace with your content -->
      <div class="py-4">
        <div class="h-96 rounded-lg  border-gray-200">
          <div>

            <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
              <li class="col-span-1 flex rounded-md shadow-sm">
                <div
                  class="flex-shrink-0 flex items-center justify-center w-16 bg-pink-600 text-white text-sm font-medium rounded-l-md">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none"
                    viewBox="0 0 24 24">
                    <path
                      d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
                    </path>
                  </svg>
                </div>
                <div
                  class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                  <div class="flex-1 truncate px-4 py-3 text-sm">
                    <a href="#" class="font-semibold text-gray-700 hover:text-gray-600">Occupied Room</a>
                  </div>
                  <div class="flex-shrink-0 pr-2">
                    {{-- <button type="button" 
                      class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white bg-transparent text-green-500 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                      
                    </button> --}}
                    <a href="{{ route('office.occupied-rooms') }}" target="_blank"
                      class=" text-green-500 hover:text-gray-500">
                      <svg class="w-4 h-4 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792"
                        fill="currentColor">
                        <path
                          d="M1408 928v320c0 159-129 288-288 288H288c-159 0-288-129-288-288V416c0-159 129-288 288-288h704c18 0 32 14 32 32v64c0 18-14 32-32 32H288c-88 0-160 72-160 160v832c0 88 72 160 160 160h832c88 0 160-72 160-160V928c0-18 14-32 32-32h64c18 0 32 14 32 32zm384-864v512c0 35-29 64-64 64-17 0-33-7-45-19l-176-176-652 652c-6 6-15 10-23 10s-17-4-23-10L695 983c-6-6-10-15-10-23s4-17 10-23l652-652-176-176c-12-12-19-28-19-45 0-35 29-64 64-64h512c35 0 64 29 64 64z">
                        </path>
                      </svg>
                    </a>
                  </div>
                </div>
              </li>
              <li class="col-span-1 flex rounded-md shadow-sm">
                <div
                  class="flex-shrink-0 flex items-center justify-center w-16 bg-green-600 text-white text-sm font-medium rounded-l-md">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none"
                    viewBox="0 0 24 24">
                    <path
                      d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
                    </path>
                  </svg>
                </div>
                <div
                  class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                  <div class="flex-1 truncate px-4 py-3 text-sm">
                    <a href="#" class="font-semibold  text-gray-700 hover:text-gray-600">Guest</a>
                  </div>
                  <div class="flex-shrink-0 pr-2">
                    <button type="button"
                      class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white bg-transparent text-green-500 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                      <svg class="w-5 h-5 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792"
                        fill="currentColor">
                        <path
                          d="M1408 928v320c0 159-129 288-288 288H288c-159 0-288-129-288-288V416c0-159 129-288 288-288h704c18 0 32 14 32 32v64c0 18-14 32-32 32H288c-88 0-160 72-160 160v832c0 88 72 160 160 160h832c88 0 160-72 160-160V928c0-18 14-32 32-32h64c18 0 32 14 32 32zm384-864v512c0 35-29 64-64 64-17 0-33-7-45-19l-176-176-652 652c-6 6-15 10-23 10s-17-4-23-10L695 983c-6-6-10-15-10-23s4-17 10-23l652-652-176-176c-12-12-19-28-19-45 0-35 29-64 64-64h512c35 0 64 29 64 64z">
                        </path>
                      </svg>
                    </button>
                  </div>
                </div>
              </li>
              <li class="col-span-1 flex rounded-md shadow-sm">
                <div
                  class="flex-shrink-0 flex items-center justify-center w-16 bg-gray-600 text-white text-sm font-medium rounded-l-md">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none"
                    viewBox="0 0 24 24">
                    <path
                      d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
                    </path>
                  </svg>
                </div>
                <div
                  class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                  <div class="flex-1 truncate px-4 py-3 text-sm">
                    <a href="#" class="font-semibold  text-gray-700 hover:text-gray-600">Overdue Rooms</a>
                  </div>
                  <div class="flex-shrink-0 pr-2">
                    <button type="button"
                      class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white bg-transparent text-green-500 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                      <svg class="w-5 h-5 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792"
                        fill="currentColor">
                        <path
                          d="M1408 928v320c0 159-129 288-288 288H288c-159 0-288-129-288-288V416c0-159 129-288 288-288h704c18 0 32 14 32 32v64c0 18-14 32-32 32H288c-88 0-160 72-160 160v832c0 88 72 160 160 160h832c88 0 160-72 160-160V928c0-18 14-32 32-32h64c18 0 32 14 32 32zm384-864v512c0 35-29 64-64 64-17 0-33-7-45-19l-176-176-652 652c-6 6-15 10-23 10s-17-4-23-10L695 983c-6-6-10-15-10-23s4-17 10-23l652-652-176-176c-12-12-19-28-19-45 0-35 29-64 64-64h512c35 0 64 29 64 64z">
                        </path>
                      </svg>
                    </button>
                  </div>
                </div>
              </li>
              <li class="col-span-1 flex rounded-md shadow-sm">
                <div
                  class="flex-shrink-0 flex items-center justify-center w-16 bg-blue-600 text-white text-sm font-medium rounded-l-md">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none"
                    viewBox="0 0 24 24">
                    <path
                      d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
                    </path>
                  </svg>
                </div>
                <div
                  class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                  <div class="flex-1 truncate px-4 py-3 text-sm">
                    <a href="#" class="font-semibold  text-gray-700 hover:text-gray-600">Roomboys</a>
                  </div>
                  <div class="flex-shrink-0 pr-2">
                    <button type="button"
                      class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white bg-transparent text-green-500 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                      <svg class="w-5 h-5 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792"
                        fill="currentColor">
                        <path
                          d="M1408 928v320c0 159-129 288-288 288H288c-159 0-288-129-288-288V416c0-159 129-288 288-288h704c18 0 32 14 32 32v64c0 18-14 32-32 32H288c-88 0-160 72-160 160v832c0 88 72 160 160 160h832c88 0 160-72 160-160V928c0-18 14-32 32-32h64c18 0 32 14 32 32zm384-864v512c0 35-29 64-64 64-17 0-33-7-45-19l-176-176-652 652c-6 6-15 10-23 10s-17-4-23-10L695 983c-6-6-10-15-10-23s4-17 10-23l652-652-176-176c-12-12-19-28-19-45 0-35 29-64 64-64h512c35 0 64 29 64 64z">
                        </path>
                      </svg>
                    </button>
                  </div>
                </div>
              </li>
              <li class="col-span-1 flex rounded-md shadow-sm">
                <div
                  class="flex-shrink-0 flex items-center justify-center w-16 bg-red-600 text-white text-sm font-medium rounded-l-md">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="currentColor" stroke="none"
                    viewBox="0 0 24 24">
                    <path
                      d="m20 8-6-6H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zM9 19H7v-9h2v9zm4 0h-2v-6h2v6zm4 0h-2v-3h2v3zM14 9h-1V4l5 5h-4z">
                    </path>
                  </svg>
                </div>
                <div
                  class="flex flex-1 items-center justify-between truncate rounded-r-md border-t border-r border-b border-gray-200 bg-white">
                  <div class="flex-1 truncate px-4 py-3 text-sm">
                    <a href="#" class="font-semibold  text-gray-700 hover:text-gray-600">Sales</a>
                  </div>
                  <div class="flex-shrink-0 pr-2">
                    <button type="button"
                      class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white bg-transparent text-green-500 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                      <svg class="w-5 h-5 " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1792 1792"
                        fill="currentColor">
                        <path
                          d="M1408 928v320c0 159-129 288-288 288H288c-159 0-288-129-288-288V416c0-159 129-288 288-288h704c18 0 32 14 32 32v64c0 18-14 32-32 32H288c-88 0-160 72-160 160v832c0 88 72 160 160 160h832c88 0 160-72 160-160V928c0-18 14-32 32-32h64c18 0 32 14 32 32zm384-864v512c0 35-29 64-64 64-17 0-33-7-45-19l-176-176-652 652c-6 6-15 10-23 10s-17-4-23-10L695 983c-6-6-10-15-10-23s4-17 10-23l652-652-176-176c-12-12-19-28-19-45 0-35 29-64 64-64h512c35 0 64 29 64 64z">
                        </path>
                      </svg>
                    </button>
                  </div>
                </div>
              </li>


            </ul>
          </div>

        </div>
      </div>
      <!-- /End replace -->
    </div>
  </div>
</x-back-office-layout>
