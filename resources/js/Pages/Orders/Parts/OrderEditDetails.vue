<script setup>
    import Form from '@/Components/Form.vue';
    import InputField from '@/Components/Inputs/InputField.vue';
    import BindableTextField from '@/Components/Inputs/BindableTextField.vue';
    import CheckboxField from '@/Components/Inputs/CheckboxField.vue';
    import SelectField from '@/Components/Inputs/SelectField.vue';
    import SearchableField from '@/Components/Inputs/SearchableField.vue';
    import TextAreaField from '@/Components/Inputs/TextAreaField.vue';
    import _config from '@/config/Pages/Orders/Form/_details';
    import {reactive, watch} from "vue";


    import {store as useStore} from '@/Stores/orderStore';
    import { ArrowDown, CopyDocument, Delete, Plus } from '@element-plus/icons-vue';
    import OrderCalcHelper from "@/lib/OrderCalcHelper.js";

    console.log(_config.sections.general)
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
            price_total: 0,
            price_net: 0,
            price_gross: 0,
            price_tax: 0,
            price_discount: 0,
            purchase_price: 0,
            profit: -10,
        }
    })

    const calcSummary = () => {
        
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

    watch(state.parcels, (a, b) => {
        store.update('parcels', state.parcels)
        calc();
    }, {deep: true})
    calc();

</script>
<template>
    <div class="grid grid-flow-col grid-cols-4 gap-4 place-items-start">
        <div class="grid col-span-3 gap-4 px-4">
            <p>Auftragsdetails</p>
            <div class="grid gap-4">
                <div v-for="row in _config.sections.general.rows" class="grid grid-flow-row " :class="{[row.className]: true}">
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
            <p>Packstücke</p>
            <div class="grid gap-4">
                <div v-for="parcel,index in state.parcels" :key="index" class="grid grid-flow-col gap-4">
                    <div class="grid justify-center w-6 place-items-center">
                        <span class="grid font-bold text-corporate-700 text-1 place-items-center">{{index + 1}}</span>
                    </div>
                    <div v-for="field in _config.sections.parcels.fields">
                        
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
                <button @click="add()" class="p-2 mt-3 text-white transition-colors duration-200 rounded-md place-self-end bg-primary-700 hover:bg-primary-600"><el-icon><Plus /></el-icon> {{ $t('buttons.general.add_parcel') }}</button>
                
                <div class="grid grid-flow-col gap-4 pt-4">
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/packages.svg" alt="Parcel Icon" class="w-12 h-12" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_parcels") }}</p>
                            <span class="text-[15px]">{{ parseInt(state.calculations.count) }}</span>
                        </div>
                    </div>
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/volume.svg" alt="Parcel Icon" class="w-12 h-12" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_volume") }}</p>
                            <span class="text-[15px]">{{ parseFloat(state.calculations.volume / (100*100*100)).toFixed(2) }} m<sup>3</sup></span>
                        </div>
                    </div>
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/area.svg" alt="Parcel Icon" class="w-12 h-12" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_area") }}</p>
                            <span class="text-[15px]">{{ parseFloat(state.calculations.area / (100*100)).toFixed(2) }} m<sup>2</sup></span>
                        </div>
                    </div>
                    <div class="grid grid-flow-col gap-2 p-2 rounded-md bg-slate-100">
                        <div class="rounded-md columns-auto w-14 h-14 bg-slate-200 place-items-center">
                            <img src="/images/svg/weight.svg" alt="Parcel Icon" class="w-12 h-12" />
                        </div>
                        <div class="justify-start w-full">
                            <p class="font-bold">{{ $t("pages.orders.form.sections.parcel_summary.total_weight") }}</p>
                            <span class="text-[15px]">{{ parseFloat(state.calculations.weight).toFixed(2) }} kg</span>
                        </div>
                    </div>
                </div>
            </div>
            <p>Adressen</p>
            <div class="grid max-w-full grid-flow-col gap-4 pb-4 overflow-x-scroll">
                <div v-for="address,ai in content.addresses" class="w-[350px] p-3 bg-slate-50 rounded-md">
                    <div v-for="row,ri in _config.sections.addresses.rows" class="grid grid-flow-col gap-4 mb-4 last:mb-0" :class="row.className">
                        <div v-for="field,fi in row.fields" class="grid gap-4" :class="field.className">
                            <div class="relative pt-8" v-if="field.type==='badge_dd'">
                                <span class="absolute top-0 right-0 px-3 text-white duration-200 rounded-full cursor-pointer hover:bg-primary-600 bg-primary-700" :data-dropdown-toggle="`${ai}_${ri}_${fi}`">{{ $t(address[field.name]) }}</span>
                                <div role="dropdown" :id="`${ai}_${ri}_${fi}`" class="hidden z-[100] bg-white rounded-md cursor-pointer overflow-clip shadow-md">
                                    <ul>
                                        <li class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.pickup") }}</li>
                                        <li class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.delivery") }}</li>
                                        <li class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.billing") }}</li>
                                        <li class="p-1 px-3 hover:bg-primary-700 hover:text-white">{{ $t("general.badge.address.headquarter") }}</li>
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
                                    state.addresses[index][field.name] = event.target.value;
                                }"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <p>Finanzen</p>
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
            <p>Fahrzeuganforderungen</p>
            <div class="p-8 bg-slate-200">
                <pre>{{ content.details }}</pre>
            </div>
        </div>
        <div class="grid w-full text-right">
            <p class="font-bold text-[18px] mb-3">Zusammenfassung</p>
            <p class="font-bold text-[15px] mb-4">Auftragsdetails</p>
            <div class="grid gap-2 mb-4">
                <div class="">
                    <p class="font-semibold text-corporate-700">Auftragsnummer</p>
                    <p>{{ content.order_number }}</p>
                </div>
                <div class="">
                    <p class="font-semibold text-corporate-700">Auftragsdatum</p>
                    <p>{{ content.order_date }}</p>
                </div>
                <div class="">
                    <p class="font-semibold text-corporate-700">Leistungsdatum</p>
                    <p>{{ content.month_and_year }}</p>
                </div>
                <div class="">
                    <p class="font-semibold text-corporate-700">Storniert</p>
                    <p>{{ content.details.date_of_cancellation }}</p>
                </div>
            </div>
            <p class="font-bold text-[15px]">Finanzinformationen</p>
            <div class="grid gap-2 mb-4">
                <div>
                    <p class="font-semibold text-corporate-700">Verkaufspreis</p>
                    <p>{{ content.details.order_number }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Gebühren</p>
                    <p>{{ content.order_date }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Rabatte</p>
                    <p>{{ content.order_date }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Einkaufspreis</p>
                    <p>{{ content.order_date }}</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Summe</p>
                    <p>{{ parseFloat(state.summary.profit).toFixed(2) }} €</p>
                </div>
                <div>
                    <p class="font-semibold text-corporate-700">Typ</p>
                    <p :class="{'text-corporate-500': state.summary.profit >= 0, 'text-red-700': state.summary.profit < 0 }">{{ state.summary.profit >= 0 ? "Gewinn" : "Verlust" }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
