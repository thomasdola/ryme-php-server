<style></style>

<template>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Schedule</th>
                <th>Started On</th>
                <th>Ending On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="ad in ads">
                <td>Update software</td>
                <td>Update software</td>
                <td>Update software</td>
                <td>Update software</td>
                <td>
                    <button type="button">stop</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script type="text/babel">
    export default {
        props: ['ads']
    }
</script>

