<script setup>
    import Form from '@/Components/Form.vue';
    import InputField from '@/Components/Inputs/InputField.vue';
    import BindableTextField from '@/Components/Inputs/BindableTextField.vue';
    import CheckboxField from '@/Components/Inputs/CheckboxField.vue';
    import SelectField from '@/Components/Inputs/SelectField.vue';
    import SearchableField from '@/Components/Inputs/SearchableField.vue';
    import TextAreaField from '@/Components/Inputs/TextAreaField.vue';
    import _config from '@/config/Pages/Orders/Form/_details';
    import {reactive, watch, ref, onMounted} from "vue";

    import Datepicker from 'flowbite-datepicker/Datepicker';
    
    import {store as useStore} from '@/Stores/orderStore';
    import { Check, CopyDocument, Delete, DocumentCopy, Plus } from '@element-plus/icons-vue';
    import OrderCalcHelper from "@/lib/OrderCalcHelper.js";
    import moment from 'moment/moment';
    
    import { initFlowbite } from 'flowbite';

    defineProps({
        useContent: {
            type: Boolean,
            required: false,
        },
    });

    let store = useStore();
    let content = store.getOne();
    
    const getEmpty = () => {
        return {
            "id": null,
            "tms_order_id": content.id,
            "is_hazardous": false,
            "information": null, 
            "name": null, 
            "height": 0, 
            "length": 0, 
            "width": 0, 
            "weight": 0,
            "number": null, 
            "stackable": false, 
        }
    }

    let state = reactive({
        parcels: content.parcels || [],
        calculations: {
            volume: 0, 
            area: 0, 
            weight: 0, 
            count: 0
        },
        summary: {
            price_net: content.details.price_net,
            provision: content.provision,
            discount: content.details.discount,
            purchase_price: content.purchase_price,
            price_vat: content.details.price_vat,
        }
    })



    const calcSummary = () => {
        return state.summary.price_net - state.summary.provision - state.summary.discount - state.summary.purchase_price;
    }

    let dup = (item) => {
        let _template = {
            "id": null,
            "tms_order_id": item.parent,
            "is_hazardous": item.is_hazardous,
            "information": item.information, 
            "name": item.name, 
            "height": item.height, 
            "length": item.length, 
            "width": item.width, 
            "weight": item.weight,
            "number": item.number, 
            "stackable": item.stackable, 
        }
        state.parcels.push(_template);
    }

    let rem = (index) => {
        let rest = state.parcels.splice(index, 1);
        if(state.parcels.length === 0) state.parcels.push(getEmpty());
    }

    let add = () => {
        let item = getEmpty();
        state.parcels.push(item)
    }

    const calc = () => {
        state.calculations = OrderCalcHelper.calculate(state.parcels);
    }


    const setAddressType = (address, type, dd_target) => {
        address.address_type = type;
        document.getElementById(dd_target).click();
    }

    const addEmptyAddress = () => {
        content.addresses.push({
            "order_id": content?.order_number, 
            "customer_id": null, 
            "forwarder_id": null, 
            "salutation_id": null, 
            "title_id": null, 
            "country_id": null, 
            "partner_id": null, 
            "company_name": null, 
            "address_type": null, 
            "first_name": null, 
            "last_name": null, 
            "street": null, 
            "house_number": null, 
            "zip_code": null, 
            "city": null, 
            "state": null, 
            "address_additional_information": null, 
            "phone": null, 
            "email": null, 
            "avis_phone": null, 
            "date_from": null, 
            "date_to": null, 
            "comments": {}, 
            "country": {id: 276, country_name: "Germany"}, 
            "customer": {},
            "forwarder": {}
        })
    }

    var feedback = false
    var copyTimeout = null;
    var copiedAddress = ref(null);

    const copyAddressToClipboard = (address, ai) => {
        if(copyTimeout) clearTimeout(copyTimeout);
        copiedAddress.value = ai
        feedback = true;

        navigator.clipboard.writeText(
            address.company_name + "\n" + address.first_name + " " + address.last_name + "\n" +
            address.street + " " + address.house_number + "\n" + address.zip_code + " " + address.city + "\n" +
            address.country.country_name + "\n" + address.phone + "\n" + address.email
        );

        copyTimeout = setTimeout(() => {
            feedback = false;
            copiedAddress.value = null
        }, 3000)
    }

    watch(state.parcels, (a, b) => {
        store.update('parcels', state.parcels)
        calc();
    }, {deep: true})
    calc();
    
    const removeAddress = (address) => {
        content.addresses.splice(content.addresses.indexOf(address), 1);
    }
    
    onMounted(() => {
        initFlowbite();
        new Datepicker(document.getElementById("order_date_of_service_datepicker"), {
            
        })
        document.getElementById('order_date_of_service_datepicker').addEventListener('datepicker:change', (event) => {
            content.month_and_year = moment(event.target.value).format('DD.MM.YYYY');
        })
        document.getElementById('order_date_of_service_datepicker').value = moment(content.month_and_year).format('DD.MM.YYYY');
    })
    
</script>
<template>
    
    <div class="grid grid-flow-col grid-cols-4 gap-4 place-items-start">
        <div class="grid col-span-3 gap-8 px-4">
            <p class="mt-10 text-[16px] font-bold text-corporate-700">Auftragsdetails</p>
            <div class="grid gap-4">
                <div v-for="row in _config.sections.general.rows" class="grid grid-flow-row" :class="row.className ?? 'grid-cols-2'">
                    <div v-for="field in row.fields" :key="field.name" class="col-auto" :class="{[field.className]: true}">
                        <InputField 
                            v-if="field.type === 'input'" 
                            :field="field" 
                            :store="store" 
                            :data="content" 
                            />
                            
                        <CheckboxField 
                            v-else-if="field.type === 'check'" 
                            :field="field" 
                            :store="store" 
                            :data="content" 
                            />
                            
                        <SelectField 
                            v-else-if="field.type === 'select'" 
                            :field="field" 
                            :store="store" 
                            :data="content" 
                            />
                            
                        <SearchableField 
                            v-else-if="field.type === 'search'" 
                            :field="field" 
                            :store="store" 
                            :data="content" 
                            />
                            
                        <BindableTextField 
                            v-else-if="field.type === 'text'" 
                            :field="field" 
                            :store="store" 
                            :data="content" 
                            :val="field.subfield ? content[field.name][field.subfield] : content[field.name]"
                            />
                    </div>
                </div>
            </div>
            <p class="mt-10 text-[16px] font-bold text-corporate-700">Adressen</p>
            <div class="grid max-w-full">
                <div class="grid max-w-full grid-flow-col gap-4 pb-4 overflow-x-scroll">
                    <div v-for="address,ai in content.addresses" class="grid w-[350px] p-3 bg-slate-50 rounded-md gap-4">
                        
                        <div v-for="row,ri in _config.sections.addresses.rows" :class="row.className">
                            <div v-for="field,fi in row.fields" :class="field.className">
                                <div class="relative pt-8" v-if="field.type==='badge_dd'">
                                    <span :id="`dd_toggle-${ai}_${ri}_${fi}`" class="absolute top-0 right-0 px-3 text-white duration-200 rounded-full cursor-pointer hover:bg-primary-600 bg-primary-700" :data-dropdown-toggle="`${ai}_${ri}_${fi}`">{{ $t(address[field.name]) }}</span>
                                    <div role="dropdown" :id="`${ai}_${ri}_${fi}`" class="hidden z-[100] bg-white rounded-md cursor-pointer overflow-clip shadow-md">
                                        <ul>
                                            <li @click="setAddressType(content.addresses[ai], 'labels.address-pickup',`dd_toggle-${ai}_${ri}_${fi}`)" class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.pickup") }}</li>
                                            <li @click="setAddressType(content.addresses[ai], 'labels.address-delivery',`dd_toggle-${ai}_${ri}_${fi}`)" class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.delivery") }}</li>
                                            <li @click="setAddressType(content.addresses[ai], 'labels.address-billing',`dd_toggle-${ai}_${ri}_${fi}`)" class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.billing") }}</li>
                                            <li @click="setAddressType(content.addresses[ai], 'labels.address-headquarter',`dd_toggle-${ai}_${ri}_${fi}`)" class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.headquarter") }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <BindableTextField 
                                    v-if="field.type === 'text'" 
                                    :field="field" 
                                    :store="store" 
                                    :data="address"
                                    :val="field.subfield ? address[field.name][field.subfield] : address[field.name]"
                                    @input="(event) => {
                                        content.addresses[ai][field.name] = event.target.value;
                                    }"
                                />
                            </div>
                        </div>
                        <div class="grid justify-between grid-flow-col">
                            <button @click="removeAddress(address)" class="text-red-700 cursor-pointer hover:text-red-500"><el-icon><Delete /></el-icon></button>
                            <button class="grid justify-start gap-2 place-items-center" @click="copyAddressToClipboard(address, ai)">
                                <span class="grid justify-start grid-flow-col gap-2 text-green-500 place-items-center" v-if="copiedAddress === ai && feedback === true">
                                    <el-icon size="18"><Check /></el-icon>
                                    <span>Addresse kopiert!</span>
                                </span>
                                <span class="grid justify-start grid-flow-col gap-2 place-items-center" v-else>
                                    <el-icon size="18"><DocumentCopy /></el-icon>
                                    <span>Kopiere Adresse</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="grid justify-end w-full grid-flow-row place-items-end">
                    <button @click="addEmptyAddress()" class="grid grid-flow-col gap-2 p-2 mt-3 text-white transition-colors duration-200 rounded-md place-items-center place-self-end bg-primary-700 hover:bg-primary-600"><el-icon><Plus /></el-icon> {{ $t('buttons.general.add_address') }}</button>
                </div>
            </div>

            <p class="mt-10 text-[16px] font-bold text-corporate-700">Packstücke</p>
            <div class="grid gap-4">
                <div v-for="parcel,index in state.parcels" :key="index" class="grid grid-flow-row gap-4" :class="parcel.className ?? 'grid-flow-row grid-cols-7'">
                    <div class="grid justify-center w-6 place-items-center">
                        <span class="grid font-bold text-corporate-700 text-1 place-items-center">{{index + 1}}</span>
                    </div>
                    <div v-for="field in _config.sections.parcels.fields" :class="field.className ?? 'grid-flow-col'">
                        <BindableTextField 
                            v-if="field.type === 'text'" 
                            :field="field" 
                            :store="store" 
                            :data="parcel"
                            :val="parcel[field.name]"
                            @input="(event) => {
                                state.parcels[index][field.name] = event.target.value;
                            }"
                            />
                            
                        <CheckboxField 
                            v-else-if="field.type === 'check'" 
                            :field="field" 
                            :store="store" 
                            :data="parcel" 
                            />
                            
                        <SelectField 
                            v-else-if="field.type === 'select'" 
                            :field="field" 
                            :store="store" 
                            :data="parcel" 
                            />
                            
                        <SearchableField 
                            v-else-if="field.type === 'search'" 
                            :field="field" 
                            :store="store" 
                            :data="parcel" 
                            />
                            
                        <TextAreaField 
                            v-else-if="field.type === 'input'" 
                            :field="field" 
                            :store="store" 
                            :data="parcel" 
                            />
                    
                    </div>
                    <div class="grid justify-end w-24 grid-flow-col gap-4 place-items-center">
                        <button @click="dup(parcel)" class="grid w-10 h-10 text-white transition-colors rounded-md hover:bg-primary-600 duration-200ms place-items-center bg-primary-700"><el-icon><CopyDocument /></el-icon></button>
                        <button @click="rem(index)" class="grid w-10 h-10 text-white transition-colors bg-red-700 rounded-md hover:bg-red-600 duration-200ms place-items-center"><el-icon><Delete /></el-icon></button>
                    </div>
                </div>
                <button @click="add()" class="grid grid-flow-col gap-2 p-2 mt-3 text-white transition-colors duration-200 rounded-md place-items-center place-self-end bg-primary-700 hover:bg-primary-600"><el-icon><Plus /></el-icon> {{ $t('buttons.general.add_parcel') }}</button>
                
                <div class="grid grid-flow-col gap-4 pt-4">
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="grid rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/packages.svg" alt="Parcel Icon" class="w-10 h-10" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_parcels") }}</p>
                            <span class="text-[15px]">{{ parseInt(state.calculations.count) }}</span>
                        </div>
                    </div>
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="grid rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/volume.svg" alt="Parcel Icon" class="w-10 h-10" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_volume") }}</p>
                            <span class="text-[15px]">{{ parseFloat(state.calculations.volume / (100*100*100)).toFixed(2) }} m<sup>3</sup></span>
                        </div>
                    </div>
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="grid rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/area.svg" alt="Parcel Icon" class="w-10 h-10" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_area") }}</p>
                            <span class="text-[15px]">{{ parseFloat(state.calculations.area / (100*100)).toFixed(2) }} m<sup>2</sup></span>
                        </div>
                    </div>
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="grid rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/weight.svg" alt="Parcel Icon" class="w-10 h-10" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_weight") }}</p>
                            <span class="text-[15px]">{{ parseFloat(state.calculations.weight).toFixed(2) }} kg</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <p class="mt-10 text-[16px] font-bold text-corporate-700">Finanzen</p>
            <div class="">
                <div v-for="parcel,index in state.parcels" class="py-2 border-b last:border-b-0">
                    <div class="grid grid-flow-col gap-4">
                        <p>{{ $t('Packstück') }} {{ index + 1 }}</p>
                        <p>{{ $t('Packstück') }} {{ index + 1 }}</p>
                        <p>{{ $t('Packstück') }} {{ index + 1 }}</p>
                        <p>{{ $t('Packstück') }} {{ index + 1 }}</p>
                    </div>
                    <div class="grid grid-flow-col gap-4">
                        <p>{{ parcel.information }}</p>
                    </div>
                </div>
            </div>
            <p class="mt-10 text-[16px] font-bold text-corporate-700">Fahrzeuganforderungen</p>
            <div class="p-8 bg-slate-200">
                <pre>{{ content.details }}</pre>
            </div>
        </div>
        <div class="grid w-full text-right">
            <p class="font-bold text-[18px] mt-10 mb-7">Zusammenfassung</p>
            <div class="grid gap-4 p-4 mb-4 border rounded bg-slate-50">
                <p class="font-bold text-[15px] mb-0">Auftragsdetails</p>
                <div class="">
                    <p class="font-semibold text-corporate-700">Auftragsnummer</p>
                    <p>{{ content.order_number }}</p>
                </div>
                <div class="">
                    <p class="font-semibold text-corporate-700">Auftragsdatum</p>
                    <p>{{ moment(content.order_date).format("DD.MM.YYYY") }}</p>
                </div>
                <div class="">
                    <p class="font-semibold text-corporate-700">Leistungsdatum</p>
                    <p>
                        <div class="relative grid justify-end max-w-sm grid-flow-row">
                            <input
                            id="order_date_of_service_datepicker"
                            datepicker
                            datepicker-buttons
                            datepicker-autoselect-today
                            :datepicker-title="$t('select-date')"
                            datepicker-format="DD.MM.YYYY"
                            :value="content.month_and_year ?? null"
                            type="text" 
                            class="p-0 text-right bg-transparent border-0 appearance-none cursor-pointer focus:ring-0 focus:border-0 focus:outline-none"
                            placeholder="Select date">
                            <span class="cursor-pointer text-corporate-700" @click="content.month_and_year = moment().format('DD.MM.YYYY')">Leistung ist Heute</span>
                        </div>
                    </p>
                </div>
                <div class="">
                    <p class="font-semibold text-corporate-700">Storniert</p>
                    <p>{{ content.details.date_of_cancellation !== null && content.details.date_of_cancellation !== '' ?  moment(content.details.date_of_cancellation).format("DD.MM.YYYY") : $t('labels.general.not_cancelled') }}</p>
                </div>
            </div>
            <div class="grid gap-4 p-4 mb-2 border rounded bg-slate-50">
                <p class="font-bold text-[15px] mb-0">Finanzinformationen</p>
                <div>
                    <p class="font-semibold text-corporate-700">Verkaufspreis</p>
                    <p>{{ state.summary.price_net }} {{ content.currency_code ?? "€" }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Gebühren</p>
                    <p>{{ state.summary.provision }} {{ content.currency_code ?? "€" }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Rabatte</p>
                    <p>{{ state.summary.discount }} {{ content.currency_code ?? "€" }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Einkaufspreis</p>
                    <p>{{ state.summary.purchase_price }} {{ content.currency_code ?? "€" }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Steuern ({{ content.details.vat_rate ?? 0}}%)</p>
                    <p>{{ state.summary.price_vat }} {{ content.currency_code ?? "€" }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Summe</p>
                    <p>{{ calcSummary().toFixed(2) }} €</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Typ</p>
                    <p :class="{'text-corporate-500': calcSummary() >= 0, 'text-red-700': calcSummary() < 0 }">{{ calcSummary() >= 0 ? "Gewinn" : "Verlust" }}</p>
                </div>
            </div>
            <div class="grid grid-flow-row gap-4 p-3 my-4 border rounded-md bg-slate-50">
                <button class="px-4 py-2 text-white rounded-md bg-primary-700 hover:bg-primary-600">Auftrag speichern</button>
                <button :disabled="content.details.date_of_cancellation !== null && content.details.date_of_cancellation !== ''" class="px-4 py-2 text-red-700 rounded-md hover:text-red-800 disabled:text-slate-500 disabled:bg-transparent disabled:hover:text-slate-500">{{ $t('buttons.general.cancel_order') }}</button>
            </div>
        </div>
    </div>
</template>
