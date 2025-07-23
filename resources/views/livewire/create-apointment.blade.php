<div>

      <form wire:submit="create">
        {{ $this->form }}

        <div class="flex justify-end p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button type="submit" class="text-white bg-primary-500 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Submit</button>
            <button data-modal-hide="appointment-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-primary-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-primary-100 dark:focus:ring-primary-700 dark:bg-primary-800 dark:text-primary-400 dark:border-primary-600 dark:hover:text-white dark:hover:bg-primary-700">Decline</button>
        </div>

    </form>

</div>
