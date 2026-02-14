export type Car = {
  // columns
  id: number
  name: string
  registration_number: string | null
  is_registered: boolean
  created_at: string | null
  updated_at: string | null
  // relations
  parts: Part[]
  // counts
  parts_count: number
  // exists
  parts_exists: boolean
}

export type Part = {
  // columns
  id: number
  name: string
  serialnumber: string
  car_id: number
  created_at: string | null
  updated_at: string | null
  // relations
  car: Car
  // counts
  // exists
  car_exists: boolean
}

export type User = {
  // columns
  id: number
  name: string
  email: string
  email_verified_at: string | null
  password?: string
  remember_token?: string | null
  created_at: string | null
  updated_at: string | null
  // relations
  notifications: DatabaseNotification[]
  // counts
  notifications_count: number
  // exists
  notifications_exists: boolean
}
