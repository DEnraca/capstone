<template>

    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="relative  justify-center text-center bg-gray-100 rounded-md p-4 shadow-2xl p-10 max-w-lg w-full mx-4">
        <audio ref="modalSound" :src="soundSrc" autoplay loop></audio>

        <div class="w-auto h-16 border-b">
            <img :src="logoSrc" alt="Logo" class="w-full h-full object-contain">
        </div>

        <div>
            <!-- Queue number -->
            <span class="text-primary-500 font-extrabold leading-none p-2" style="font-size: 3.5rem;">
                {{ queue_details.queue_number }}
            </span>

            <!-- Transaction type -->
            <p class="text-primary-400 font-bold text-4xl capitalize text-gray-700 mt-6">
                {{ queue_details.transaction }}
            </p>
        </div>
    </div>
</div>

</template>
<script>
   import {route} from 'ziggy-js';
   import axios from 'axios';
   export default {
       data() {
           return {
               showModal: false,
               queue_details: [],
               pollInterval: null,
               soundSrc: '/images/abr_queue_notif.wav',
               logoSrc: '/images/logo.png',
           };
       },
       methods: {
           fetchTransactions() {
               axios.get(route('queues-call-next'))
                   .then(response => {
                       if(response.data.status == 'success'){
                        if(response.data.data.length == 0){
                            return
                        }
                           this.queue_details = response.data.data;
                           this.displayModal()
                       }
                   })
                   .catch(error => {
                       console.error("There was an error fetching the stations:", error.message);
                   });
           },
           startPolling() {
               this.showModal = false;
               this.pollInterval = setInterval(this.fetchTransactions, 8000); // every 8 sec
           },
           stopPolling() {
               if (this.pollInterval) clearInterval(this.pollInterval);
           },
           displayModal(){
               this.stopPolling();
               this.showModal = true;
               setTimeout(() => {
                   this.showModal = false;
                   this.startPolling()
               }, 5000);
           }
       },

       mounted() {
           this.startPolling();
       },
       beforeUnmount() {
           this.stopPolling();
       },

   };
</script>
