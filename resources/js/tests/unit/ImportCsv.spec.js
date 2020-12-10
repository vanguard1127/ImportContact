import Vue from 'vue'
import { mount, shallowMount } from '@vue/test-utils'
import ImportCsv from '../../components/ImportCsv';
import BootstrapVue from "bootstrap-vue";
import VueFormWizard from 'vue-form-wizard';
import Vuelidate from "vuelidate";

window.Vue = require('vue');
Vue.use(Vuelidate);
Vue.use(BootstrapVue);
Vue.use(VueFormWizard);


describe('ImportCsv', () => {
    it('is a Vue instance', () => {
        const wrapper = shallowMount(ImportCsv,
            {
                data(){
                    return {
                        file: null,
                        mimeType: null,
                        sample: null,
                        csv: null,
                        fieldsToMap: [],
                        map: {}
                    };
                },
                propsData:
                    {
                        mapFields: {
                            'team_id': 'Team Identifier',
                            'name': 'Name',
                            'phone': 'Phone',
                            'email': 'Email',
                            'sticky_phone_number_id': 'Sticky Phone Number Identifier',
                        }
                    }

            });
        expect(wrapper.isVueInstance).toBeTruthy();
    });

    it('test do not move next wizard without csv', () => {
        const wrapper = shallowMount(ImportCsv,
            {
                data(){
                    return {
                        file: null,
                        mimeType: null,
                        sample: null,
                        csv: null,
                        fieldsToMap: [],
                        map: {}
                    };
                },
                propsData:
                    {
                        mapFields: {
                            'team_id': 'Team Identifier',
                            'name': 'Name',
                            'phone': 'Phone',
                            'email': 'Email',
                            'sticky_phone_number_id': 'Sticky Phone Number Identifier',
                        }
                    }

            });
            const nextbutton = wrapper.find('#')
    });

})
