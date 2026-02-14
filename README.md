# 🚗 Car & Parts Management System

A full-stack web application built with Laravel, Vue 3, TypeScript, Bootstrap, and MySQL for managing cars and their parts.

---

## 🛠 Tech Stack

- Backend: Laravel
- Frontend: Vue 3 + TypeScript
- UI Framework: Bootstrap 5
- Database: MySQL

---

## 🧭 Layout Structure

The application includes:

- ✅ Persistent Navbar
- ✅ Persistent Footer
- ✅ Responsive layout

### Navbar Navigation

- Cars (list all cars)
- Parts (list all parts)

---

## 📄 UI Structure

Each section (Cars / Parts) has two main pages:

### 1️⃣ Index Page

Displays all items in a table.

#### Cars
- Filterable by name

#### Parts
- Filterable by:
  - Car
  - Part name

Users can:
- Click row → View details
- Click edit button → Edit item

---

### 2️⃣ Reusable CRUD Page

A single reusable CRUD template handles:

| Scenario | Behavior |
|----------|----------|
| No item passed | ➕ Create new item |
| Item passed + viewOnly = true | 👁 View only |
| Item passed + viewOnly = false | ✏ Edit item |
| Delete action | 🗑 Remove item |

The template automatically determines behavior based on passed props.

---

## ✅ Validation

All insert and update requests are validated using:

- `StoreOrUpdateCar`
- `StoreOrUpdatePart`

Validation ensures:

- Required fields
- Proper formats
- Conditional validation rules
- Business logic constraints

---

## 📄 Project sturcture 
Standart laravel/restful path structure

### Ui components structure:
- `Layouts`: contains global layout (header + footer)
- `Cars/Parts` directory: index pages and crud.vue 
- `Crud.vue`: Page that contains input form for specific item
    - used for inserting updating and viewing items 
- `InputForm.vue` - form for specific part 
    - ( in both Car/ Part)
- `FormCard.vue` - wrapper aroud `InputForm` for unified design
- `FlashMessageNotification.vue` - component handling displaying of flash messages 
