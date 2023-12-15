/**
 * The validation rules for the form. Be careful with triggerings.
 * change is for el-select.
 * blur is for el-input.
 * change is for datepicker.
 * To turn off FE validation, simply comment out the rules inside the rules array, but leave the
 * rules array itself, that is needed.
 */
const addressValidationRules = {
    company_name: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    first_name: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    last_name: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    address_type: [
        { required: true, message: 'Please fill this field.', trigger: 'change' },
    ],
    street: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    house_number: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    zip_code: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    city: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    country: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    state: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    comment: [
        { required: true, message: 'Please fill this field.', trigger: 'blur' },
    ],
    customer_id: [
        { required: true, message: 'Please fill this field.', trigger: 'change' },
    ],
    forwarder_id: [
        { required: true, message: 'Please fill this field.', trigger: 'change' },
    ],
}

export default addressValidationRules;