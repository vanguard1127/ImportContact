<template>
    <b-form>
        <form-wizard
            @on-complete="onComplete"
            title="Import SpreadSheet"
            subtitle="Import your contacts from a spreadsheet."
        >
            <tab-content title="Upload" icon="ti-upload" :before-change="beforeStep2">
                <b-container>
                    <b-row align-h="center">
                        <b-col cols="10">
                            <p>The file can contain any number of columns but must at least contain a column with a display value for each list item and a unique identifier.</p>
                            <b-form-group>
                                <b-form-file
                                    v-model="$v.file.$model"
                                    :state="!$v.file.$invalid && !$v.mimeType.$invalid"
                                    @input="readMimeType"
                                    placeholder="Choose a file or drop it here..."
                                    drop-placeholder="Drop file here..."
                                ></b-form-file>
                                <p v-if="$v.file.$dirty && !$v.file.required">Please upload a CSV file</p>
                                <p v-if="!isMimeTypeValid">The file format is not recognised.</p>
                            </b-form-group>
                        </b-col>
                    </b-row>
                </b-container>
            </tab-content>
            <tab-content title="Map" icon="ti-link">
                <table>
                    <slot name="thead">
                        <thead>
                        <tr>
                            <th>Spreadsheet Field</th>
                            <th>Field</th>
                        </tr>
                        </thead>
                    </slot>
                    <tbody>
                        <tr v-for="(column, key) in firstRow" :key="key">
                            <td>{{column}}</td>
                            <td>
                                <select class="form-control" :name="`table_map_${key}`" v-model="map[key]">
                                    <option v-for="(field, key) in fieldsToMap" :key="key" :value="field.key">{{field.label}}</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </tab-content>
            <tab-content title="Preview" icon="ti-eye">
                <table>
                    <tbody>
                        <tr v-for="(field, key) in map" :key="key">
                            <td>{{getLabelFromIndex(field)}}</td>
<!--                            <td>{{field}}</td>-->
                            <td>
                                {{valueByIndex(1, key)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </tab-content>
        </form-wizard>
    </b-form>
</template>

<script>
import { required, minLength, between } from "vuelidate/lib/validators";
import { FormWizard, TabContent } from "vue-form-wizard";
import _ from 'lodash'
import mimeTypes from "mime-types";
import Papa from 'papaparse';


const fileMimeTypes = [
    "text/csv",
    "text/x-csv",
    "application/vnd.ms-excel",
    "text/plain"
];

export default {
    name: "ImportCsv",
    components: {
        FormWizard,
        TabContent
    },
    props: {
        mapFields: {
            required: true
        },
    },
    data() {
        return {
            file: null,
            mimeType: null,
            sample: null,
            csv: null,
            fieldsToMap: [],
            map: {}
        };
    },
    validations: {
        file: {
            required
        },
        mimeType: {
            required
        },
        wizardStep1: [ 'file', 'mimeType' ]
    },
    created () {
        if (_.isArray(this.mapFields)) {
            this.fieldsToMap = _.map(this.mapFields, (item) => {
                return {
                    key: item,
                    label: item
                }
            })
        } else {
            this.fieldsToMap = _.map(this.mapFields, (label, key) => {
                return {
                    key: key,
                    label: label
                }
            })
        }
    },
    methods: {
        onComplete: function() {
            const data = { csv: this.csv, map: this.map};
            axios
            .post('api/contact/import', data)
            .then( (response) => {
                console.log('response ', response);
                alert(response.data.success.msg + ' skipped count: ' + response.data.success.skip_count);
            });
        },
        beforeStep2: function() {
            if (this.$v.wizardStep1.$invalid) {
                return false
            } else {
                this.loadCsvForMapping(this.file)
                return true
            }
        },
        readMimeType: function() {
            if (this.file) {
                const mimeType =
                    this.file.type === ""
                        ? mimeTypes.lookup(this.file.name)
                        : this.file.type;
                if (this.validateMimeType(mimeType)) {
                    this.mimeType = mimeType;
                } else {
                    this.mimeType = null;
                }
            } else {
                this.mimeType = null;
            }
        },
        validateMimeType(type) {
            return fileMimeTypes.indexOf(type) > -1;
        },
        loadCsvForMapping(file) {
            const self = this
            this.readFile(file, (output) => {
                self.sample = _.get(Papa.parse(output, { preview: 2, skipEmptyLines: true }), 'data')
                self.csv = _.get(Papa.parse(output, { skipEmptyLines: true }), 'data')
            })
        },
        readFile (file, callback) {
            if (file) {
                const reader = new FileReader()
                reader.readAsText(file, 'UTF-8')
                reader.onload = function (evt) {
                    callback(evt.target.result)
                }
                reader.onerror = function () {
                }
            }
        },
        getLabelFromIndex(field)
        {
            for (var i = 0 ; i < this.fieldsToMap.length; i++)
            {
                if (this.fieldsToMap[i].key == field)
                {
                    return this.fieldsToMap[i].label;
                }
            }
            return '';
        },
        valueByIndex(rowIndex, key)
        {
            if (this.csv != null)
            {
                let row =  this.csv[rowIndex];
                return row[key];
            }
            return '';
        }
    },
    computed: {
        isMimeTypeValid() {
            return this.$v.file.required ? this.$v.mimeType.required : true;
        },
        firstRow () {
            return _.get(this, 'sample.0');
        },
        secondRow(){
            return _.get(this, 'sample.1');
        },

    }
};
</script>
