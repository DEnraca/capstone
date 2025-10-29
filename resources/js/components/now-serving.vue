<template>
	<div class="grid grid-cols-4 gap-1">
		<div
			v-for="(queue, index) in queues"
			:key="index"
			class="min-h-full odd:bg-primary-400 even:bg-primary-500 grid grid-rows-[auto_1fr] mb-1">
			<!-- Header -->
			<div class="text-center text-xl font-bold py-1">
				<p>
					{{ queue.station }}
				</p>

				<p
					v-if="queue.now_serving"
					class="text-red-500 text-lg">
					{{ queue.now_serving?.number }} - {{ queue.now_serving?.name }}
				</p>
			</div>

			<!-- Next in Line -->
			<div class="grid grid-rows-[10%_1fr] h-full border py-2 px-4">
				<div
					v-if="getColumns(queue.next_in_line).length"
					class="flex gap-2 mt-2 text-slate-700">
					<!-- Loop each column -->
					<div
						v-for="(col, colIndex) in getColumns(queue.next_in_line)"
						:key="colIndex"
						class="flex flex-col gap-3 pr-2">
						<!-- Loop each next-in-line person -->
						<div
							v-for="(next, nextIndex) in col"
							:key="nextIndex"
							class="rounded text-center text-md font-black">
							{{ next.number }} ({{ next.name }})
						</div>
					</div>
				</div>

				<div
					v-else
					class="rounded text-center text-md font-bold text-slate-400 mt-4">
					<em>Nothing follows</em>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { route } from "ziggy-js";
import axios from "axios";

export default {
	data() {
		return {
			queues: [],
			pollInterval: null,
		};
	},

	methods: {
		fetchTransactions() {
			axios
				.get(route("queues-next"))
				.then((response) => {
					this.queues = response.data.data;
					console.log(this.queues);
				})
				.catch((error) => {
					console.error(
						"There was an error fetching the stations:",
						error.message
					);
				});
		},

		// Split array into columns (like PHP array_chunk)
		getColumns(nextInLine, perColumn = 3) {
			const result = [];
			if (!nextInLine || !nextInLine.length) return result;

			for (let i = 0; i < nextInLine.length; i += perColumn) {
				result.push(nextInLine.slice(i, i + perColumn));
			}
			return result;
		},

		startPolling() {
			this.fetchTransactions();
			this.pollInterval = setInterval(this.fetchTransactions, 5000);
		},

		stopPolling() {
			if (this.pollInterval) clearInterval(this.pollInterval);
		},
	},

	mounted() {
		this.startPolling();
	},

	beforeUnmount() {
		this.stopPolling();
	},
};
</script>
<style>
#now-serving-cards:nth-child(odd) {
	background-color: #ea8809; /* example for blue-400 */
}

#now-serving-cards:nth-child(even) {
	background-color: #fef3c7; /* example for blue-500 */
}
</style>
