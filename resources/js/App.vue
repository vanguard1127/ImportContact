<template>
    <div id="app">
        <import-csv :mapFields="mapFields"></import-csv>
    </div>
</template>

<script>

import ImportCsv from "./components/ImportCsv";
export default {
    name: "App",
    components: {
        ImportCsv
    },
    data () {
        return {
            mapFields: {
                'team_id': 'Team Identifier',
                'name': 'Name',
                'phone': 'Phone',
                'email': 'Email',
                'sticky_phone_number_id': 'Sticky Phone Number Identifier',
            }
        }
    }
}
</script>
<style>
#app {
    font-family: "Avenir", Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
}
</style>
