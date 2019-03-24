import { mount } from '@vue/test-utils';
import expect from 'expect';
import Example from '../../../resources/assets/js/components/admin/invoices/CreateInvoice.vue';

describe('Example', () => {
	it ('says that it is an Example Component', () => {
		let wrapper = mount(Example);

		expect(wrapper.html()).toContain('Example Component');
	});
});