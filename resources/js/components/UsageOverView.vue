<template>
    <div class="container test">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th colspan="2">
                    <strong> Disk Usage Overview </strong>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Total Size:</td>
                <td>{{ item.total }}</td>
            </tr>
            <tr>
                <td>No of files:</td>
                <td>{{ item.size }}</td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>
    export default {
        mounted() {
            this.getOverview()
        },
        data: () => ({
            item: [],
            errors: []
        }),
        methods: {
            getOverview() {
                axios.get('usage-overview').then(response => {
                    this.item = response.data
                }).catch(e => {
                    this.errors.push(e)
                });
                ;
            },
        }
    }
</script>


