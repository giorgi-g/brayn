import { mount } from '@vue/test-utils';
// import expect from 'expect';
import EditInvoice from '../../../resources/assets/js/components/admin/invoices/EditInvoice.vue';

describe('EditInvoice', () => {
	let wrapper;

	beforeEach(() => {
    	wrapper = mount(EditInvoice);
  	});

	it ('says that it is an Browser Component', () => {
		expect(wrapper.html()).toContain('Browser Component');
	});
});