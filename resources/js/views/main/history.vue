<template>
  <div>
    <div class="row row-cards">
      <div class="col-sm-12">
        <h2 class="category-header">History</h2>
        <history-table></history-table>
      </div>
    </div>
  </div>
</template>

<script>
import HistoryTable from "@js/components/main/history/HistoryTable";

export default {
    name: "dashboard-view",
    components: {
        HistoryTable
    }
};
</script>
