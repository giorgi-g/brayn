/*
 *	Importing mounting function from vue test utilities `shallowMount`
 *	If our components include other components (e.g Element-UI, Swal, Multiselect)
 *	We need to mount them to our current component that is why we have to use createLocalVue
 *	To create the testing environment for vue for this current task. 
 */
import { shallowMount, createLocalVue } from '@vue/test-utils';
// Helps us to create ajax requests!
import moxios 		from 'moxios';
// Spy package
import expect from 'expect';
import sinon from 'sinon';
import { equal } from 'assert';

/*
 *	We include below packages using createLocalVue as `InvoicesBrowser` component uses them!
 */
import ElementUI 	from 'element-ui';
import locale 		from 'element-ui/lib/locale/lang/en';
import VueMoment 	from 'vue-moment';

// Import an actual  
import InvoicesBrowser from '../../../resources/assets/js/components/admin/invoices/InvoicesBrowser.vue';

describe('InvoicesBrowser', () => {
	let wrapper;
	let localVue;

	beforeEach(() => {
    	moxios.install(axios);

	    localVue = createLocalVue();
		localVue.use(ElementUI, { locale });
		localVue.use(VueMoment);

    	wrapper = shallowMount(InvoicesBrowser, { localVue });
  	});

  	it('shows the invoices fetched from the api', (done) => {
    	moxios.stubRequest('/test', {
			status: 200,
			response: [
				{
					text: 'text',
				}
			],
    	});

		let onFulfilled = sinon.spy();

      	moxios.wait(() => {
			expect(wrapper.html()).toContain('text');
        	done();
      	});
  	});
});