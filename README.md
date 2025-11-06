# 🖼️ Galeria zdjęć – PHP + MongoDB (Projekt WAI)

Projekt wykonany w ramach przedmiotu **WWW Aplikacje Internetowe (WAI)**.  
Aplikacja przedstawia realizację architektury **MVC** w czystym **PHP**, z wykorzystaniem **MongoDB** jako bazy danych.  
Umożliwia rejestrację i logowanie użytkowników, dodawanie zdjęć, zarządzanie prywatnością galerii oraz zapamiętywanie wybranych zdjęć.

---

## 🚀 Funkcjonalności

- 🔐 **Rejestracja i logowanie użytkowników**  
  - Walidacja danych wejściowych  
  - Bezpieczne haszowanie haseł przy użyciu `password_hash()`  
  - Obsługa sesji użytkownika  

- 🖼️ **Dodawanie i przeglądanie zdjęć**  
  - Upload plików graficznych (JPEG/PNG/GIF)  
  - Automatyczne generowanie miniaturek  
  - Paginacja galerii  
  - Możliwość oznaczenia zdjęcia jako **publiczne** lub **prywatne** (dla zalogowanych)  

- ❤️ **Zapamiętywanie zdjęć**  
  - Dodawanie zdjęć do listy „Zapamiętane” (w sesji)  
  - Podgląd i zarządzanie zapamiętanymi zdjęciami  


---

## ⚙️ Technologia

- **PHP 8.1+**  
- **MongoDB** (kolekcje `users` i `images`)  
- **HTML5 / CSS3 / Vanilla JS**  
- **Architektura MVC**:
  - `Controllers` – obsługa logiki akcji i routingu  
  - `Models` – reprezentacja danych (`User`, `Image`)  
  - `Services` – logika biznesowa i operacje na bazie danych  
  - `Views` – generowanie interfejsu użytkownika  

---
