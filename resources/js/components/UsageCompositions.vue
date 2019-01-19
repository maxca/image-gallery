<template>
    <div class="container">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="3"><strong> Disk Usage Compositions </strong></th>
            </tr>
            <tr>
                <th>Type</th>
                <th>No of files</th>
                <th>Size</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in lists">
                <td>{{ item.type }}</td>
                <td>{{ item.total }}</td>
                <td>{{ item.size }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getUsageCompositions();
        },
        data: () => ({
            lists: [],
            errors: []
        }),
        methods: {
            getUsageCompositions() {
                axios.get('/usage-compositions/').then(response => {
                    this.lists = response.data.data
                }).catch(e => {
                    this.errors.push(e)
                })
            },
        }
    }
</script>

