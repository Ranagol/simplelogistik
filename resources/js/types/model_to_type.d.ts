export interface Pamyra {
}
export type Pamyras = Pamyra[]

export interface TmsAddress {
  // columns
  id: number
  first_name?: string|null
  last_name?: string|null
  street: string
  house_number?: string|null
  zipcode: string
  city: string
  country: string
  state?: string|null
  type_of_address?: string|null
  comment?: string|null
  customer_id?: number|null
  forwarder_id?: number|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  customer?: TmsCustomer
  forwarder?: TmsForwarder
  cargo_orders_by_pickup_addresses?: TmsOrders
  cargo_orders_by_delivery_addresses?: TmsOrders
}
export type TmsAddresses = TmsAddress[]

export interface TmsOrderHistory {
  // columns
  id: number
  name: string
  comment: string
  forwarder_id: number
  customer_id: number
  cargo_order_id: number
  forwarding_contract_id: number
  created_at?: string|null
  updated_at?: string|null
  // relations
  forwarder?: TmsForwarder
  customer?: TmsCustomer
  cargo_order?: TmsOrder
  forwarding_contract?: TmsForwardingContract
}
export type TmsCargoHistories = TmsOrderHistory[]

export interface TmsOrder {
  // columns
  id: number
  order_number: string
  customer_id: number
  contact_id: number
  pickup_address_id: number
  delivery_address_id: number
  description: string
  shipping_price: number
  shipping_price_netto: number
  pickup_date?: string|null
  delivery_date?: string|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  customer?: TmsCustomer
  contact?: TmsContact
  pickup_address?: TmsAddress
  delivery_address?: TmsAddress
  cargo_history?: TmsOrderHistory
  invoice?: TmsInvoice
  offer_prices?: TmsOfferPrices
}
export type TmsOrders = TmsOrder[]

export interface TmsContact {
  // columns
  id: number
  salutation?: string|null
  title?: string|null
  first_name: string
  last_name: string
  phone_number: string
  email: string
  customer_id?: number|null
  forwarder_id?: number|null
  comments?: string|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  cargo_orders?: TmsOrders
  customer?: TmsCustomer
  forwarder?: TmsForwarder
}
export type TmsContacts = TmsContact[]

export interface TmsCustomer {
  // columns
  id: number
  internal_cid: string
  name: string
  email: string
  company_name?: string|null
  tax_number?: string|null
  rating?: number|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  addresses?: TmsAddresses
  cargo_orders?: TmsOrders
  contacts?: TmsContacts
  forwarding_contracts?: TmsForwardingContracts
  vehicle?: TmsVehicle
  cargo_histories?: TmsCargoHistories
  invoices?: TmsInvoices
  customer_reqs?: TmsNeededGears
}
export type TmsCustomers = TmsCustomer[]

export interface TmsNeededGear {
  // columns
  id: number
  requirement_id: number
  customer_id: number
  created_at?: string|null
  updated_at?: string|null
  // relations
  requirement?: TmsGear
  customers?: TmsCustomers
}
export type TmsNeededGears = TmsNeededGear[]

export interface TmsDispatcher {
  // columns
  id: number
  user_id: number
  name: string
  email: string
  password: string
  phone: string
  created_at?: string|null
  updated_at?: string|null
  // relations
  forwarding_contracts?: TmsForwardingContracts
  user?: User
}
export type TmsDispatchers = TmsDispatcher[]

export interface TmsForwarder {
  // columns
  id: number
  internal_fid: string
  name: string
  email: string
  company_name?: string|null
  tax_number?: string|null
  rating?: number|null
  comments?: string|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  addresses?: TmsAddresses
  contacts?: TmsContacts
  forwarding_contracts?: TmsForwardingContracts
  cargo_histories?: TmsCargoHistories
  offer_prices?: TmsOfferPrices
  transport_licenses?: TmsTransportLicenses
  vehicles?: TmsVehicles
}
export type TmsForwarders = TmsForwarder[]

export interface TmsForwardingContract {
  // columns
  id: number
  internal_fcid: string
  forwarder_id: number
  customer_id: number
  vehicle_id?: number|null
  dispatcher_id: number
  comments?: string|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  forwarder?: TmsForwarder
  customer?: TmsCustomer
  vehicle?: TmsVehicle
  dispatcher?: TmsDispatcher
  cargo_histories?: TmsCargoHistories
}
export type TmsForwardingContracts = TmsForwardingContract[]

export interface TmsInvoice {
  // columns
  id: number
  cargo_order_id: number
  customer_id: number
  forwarder_id: number
  invoice_number: string
  invoice_date: string
  currency: string
  invoice_sum: number
  tax: number
  created_at?: string|null
  updated_at?: string|null
  // relations
  cargo_order?: TmsOrder
  customer?: TmsCustomer
}
export type TmsInvoices = TmsInvoice[]

export interface TmsOfferPrice {
  // columns
  id: number
  name: string
  description: string
  offer_from?: string|null
  offer_to?: string|null
  forwarder_id: number
  cargo_order_id?: number|null
  offered_price: number
  offered_price_net?: number|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  forwarder?: TmsForwarder
  cargo_order?: TmsOrder
}
export type TmsOfferPrices = TmsOfferPrice[]

export interface TmsGear {
  // columns
  id: number
  name: string
  remarks?: string|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  customer_reqs?: TmsNeededGears
  vehicle_reqs?: TmsVehicleReqs
}
export type TmsGears = TmsGear[]

export interface TmsOfferedGear {
  // columns
  id: number
  requirement_id: number
  forwarder_id: number
  created_at?: string|null
  updated_at?: string|null
}
export type TmsOfferedGears = TmsOfferedGear[]

export interface TmsTransportLicense {
  // columns
  id: number
  forwarder_id?: number|null
  license_number: string
  license_name: string
  license_valid_from: string
  license_valid_till: string
  created_at?: string|null
  updated_at?: string|null
  // relations
  forwarder?: TmsForwarder
}
export type TmsTransportLicenses = TmsTransportLicense[]

export interface TmsVehicle {
  // columns
  id: number
  name: string
  max_weight: number
  max_pickup_weight: number
  max_pickup_width: number
  max_pickup_height: number
  max_pickup_length: number
  vehicle_type: string
  plate_number: string
  forwarder_id: number
  address_id: number
  created_at?: string|null
  updated_at?: string|null
  // relations
  forwarding_contracts?: TmsForwardingContracts
  forwarder?: TmsForwarder
  vehicle_reqs?: TmsVehicleReqs
}
export type TmsVehicles = TmsVehicle[]

export interface TmsVehicleReq {
  // columns
  id: number
  requirement_id: number
  vehicle_id: number
  created_at?: string|null
  updated_at?: string|null
  // relations
  requirement?: TmsGear
  vehicles?: TmsVehicles
}
export type TmsVehicleReqs = TmsVehicleReq[]

export interface User {
  // columns
  id: number
  name: string
  email: string
  email_verified_at?: string|null
  password?: string
  remember_token?: string|null
  created_at?: string|null
  updated_at?: string|null
  // relations
  dispatcher?: TmsDispatcher
  tokens?: PersonalAccessTokens
  notifications?: DatabaseNotifications
}
export type Users = User[]

