import Vue from 'vue'
import { mount, shallowMount } from '@vue/test-utils'
import ImportCsv from '../../components/ImportCsv';
import BootstrapVue from "bootstrap-vue";
import VueFormWizard from 'vue-form-wizard';
import Vuelidate from "vuelidate";
import { FormWizard, TabContent } from "vue-form-wizard";

window.Vue = require('vue');
Vue.use(Vuelidate);
Vue.use(BootstrapVue);
Vue.use(VueFormWizard);


describe('ImportCsv', () => {
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
    it('is a Vue instance', () => {
        expect(wrapper.isVueInstance).toBeTruthy();
    });
    it('check ImportCsv name', () => {
        expect(wrapper.name()).toBe('ImportCsv');
    });

    it('test tab click function', async () => {
        const spyBeforeStep2 = jest.spyOn(wrapper.vm, 'beforeStep2');
        const upload_tab = wrapper.findComponent({name: 'tab-content'});
        expect(upload_tab.exists()).toBeTruthy();
        const upload_tab_title = wrapper.find('#upload_tab');
        expect(upload_tab_title.is(TabContent)).toBe(true);
        upload_tab_title.props().beforeChange();
        wrapper.vm.beforeStep2();
        expect(spyBeforeStep2).toHaveBeenCalled();
        expect(wrapper.beforeStep2).toHaveBeenCalled();
    });

})
