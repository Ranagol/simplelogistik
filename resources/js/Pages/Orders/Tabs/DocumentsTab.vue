<template>
    <div class="my-8">
        <DocumentsTable
            :getData="() => {}"
            :paginationData="{}"
            :totalResults="0"
            title="labels.invoices"
            uKey="_table-invoices"
            :updateTableColum="updateInvoicesHeaders"
            :headers="invoicesHeaders"
            :data="invoiceDocs"
            :actions="null"
        />
    </div>
    <div class="my-8">
        <DocumentsTable
            :getData="() => {}"
            :paginationData="{}"
            :totalResults="0"
            title="labels.documents"
            uKey="_table-documents"
            :updateTableColum="updateDocumentsHeaders"
            :headers="documentsHeaders"
            :data="generalDocs"
            :actions="null"
        />
    </div>
</template>


<script setup>
import DocumentsTable from '@/Components/Tables/DocumentsTable.vue'
import { ref, reactive } from 'vue';

const props = defineProps({
    tabData: {
        type: Object,
        required: false
    }
})

sessionStorage.setItem('order-invoices-table-headers', null);
sessionStorage.setItem('order-douments-table-headers', null);

const invoiceDocs = reactive([
{
        id: "1",
        invoice_number: 'S3000129',
        type: 'invoice',
        created_at: '2021-09-01 12:22:14',
        download_path: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
        invoice_date: '2021-09-01',
        status: '1',
        amount: "128.14",
        tax_rate: "19",
        currency: 'EUR',
        customer: 'Customer 1',
        customer_id: "1",
        order: 'Order 1',
        order_id: "129",
        fully_paid_at: '2021-09-01',
        due_date: '2021-09-19',
    },
    {
        id: "2",
        invoice_number: 'H3000129',
        download_path: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
        type: 'credit',
        created_at: '2021-10-01 12:22:14',
        invoice_date: '2021-10-01',
        status: '1',
        amount: "128.14",
        tax_rate: "19",
        currency: 'EUR',
        customer: 'Customer 1',
        customer_id: "1",
        order: 'Order 1',
        order_id: "129",
        fully_paid_at: '2021-09-01',
        due_date: '2021-09-19',
    },
])

const generalDocs = reactive([
    {
        id: 1,
        file_name: 'Versandlabel',
        download_path: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
        created_at: '2021-09-01 12:22:14',
        file_type: 'pdf',
        uploaded_at: '2021-09-01 12:22:14',
        uploaded_by: 'User 1',
    },
    {
        id: 2,
        file_name: 'Ablagevereinbarung',
        download_path: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
        created_at: '2021-08-01 12:22:14',
        file_type: 'pdf',
        uploaded_at: '2021-08-01 12:22:14',
        uploaded_by: 'User 1',
    },
    {
        id: 3,
        file_name: 'Zollinhaltserklärung',
        download_path: 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
        created_at: '2021-07-01 12:22:14',
        file_type: 'docx',
        uploaded_at: '2021-07-01 12:22:14',
        uploaded_by: 'Service Employee 1',
    },
])

// Column Template for the Invoices Table
var _invTableHeaders = [
    {key: 'id', text: "labels.id",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'invoice_number', text: "labels.number",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'type', text: "labels.type",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'created_at', text: "labels.created_at",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'invoice_date', text: "labels.invoice_date",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'status', text: "labels.status",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'amount', text: "labels.amount",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'tax_rate', text: "labels.tax_rate",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'currency', text: "labels.currency",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'fully_paid_at', text: "labels.fully_paid_at",searchable: true, orderable: true, sortable: true, show: true},
    {key: 'due_date', text: "labels.due_date",searchable: true, orderable: true, sortable: true, show: true},
]

// Column Template for the Documents Table
var _docTableHeaders = [
    {key: 'file_name', text: "labels.file-name", searchable: true, orderable: true, sortable: true, show: true},
    {key: 'file_type', text: "labels.file-type", searchable: true, orderable: true, sortable: true, show: true},
    {key: 'uploaded_by', text: "labels.uploaded-by", searchable: true, orderable: true, sortable: true, show: true},
    {key: 'created_at', text: "labels.created-at", searchable: true, orderable: true, sortable: true, show: true},
]

// Load the stored table headers from the session storage
const storedInvoicesHeaders = sessionStorage.getItem('order-invoices-table-headers') 
const storedDoumentsHeaders = sessionStorage.getItem('order-douments-table-headers') 


var _invoicesHeaders;
var _documentsHeaders;

// If there are stored table headers, use them
if(storedDoumentsHeaders !== "null"){
    _documentsHeaders = JSON.parse(storedDoumentsHeaders)
} else {
    _documentsHeaders = _docTableHeaders
}

if(storedInvoicesHeaders !== "null"){
    _invoicesHeaders = JSON.parse(storedInvoicesHeaders)
} else {
    _invoicesHeaders = _invTableHeaders
}

// Make the table headers reactive
var invoicesHeaders = reactive(_invoicesHeaders)
var documentsHeaders = reactive(_documentsHeaders)



const updateInvoicesHeaders = (key, val) => {
    invoicesHeaders = invoicesHeaders.map((item) => {
        if(item.key === key) item.show = val
        return item
    })
    reactive(invoicesHeaders)

    sessionStorage.setItem('order-invoices-table-headers', JSON.stringify(invoicesHeaders))
}
const updateDocumentsHeaders = (key, val) => {
    documentsHeaders = documentsHeaders.map((item) => {
        if(item.key === key) item.show = val
        return item
    })
    reactive(documentsHeaders)
    
    sessionStorage.setItem('order-douments-table-headers', JSON.stringify(documentsHeaders))
}

</script>