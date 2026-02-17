# Merryweather: Smart Water Intelligence

**Merryweather** is an advanced water management ecosystem designed to eliminate waste and optimize consumption. By integrating precise sensor technology with data analytics, Merryweather provides real-time insights into water storage, quality, and usage patterns.

---

## Overview

The goal of this project is to promote **water conservation** through smart monitoring. The system utilizes a specialized water sensor to track tank levels and water integrity, helping users transition from passive storage to active management.

### Key Capabilities
* **Precision Tracking:** High-accuracy measurements of water levels within storage tanks.
* **Quality Assurance:** Monitoring parameters to ensure the water is safe and clean.
* **Smart Patterns:** Intelligent detection of:
    * **Excessive Usage:** Identifying potential leaks or wastage.
    * **Non-existent Usage:** Detecting blockages or supply interruptions.

---

## Data Architecture

Merryweather stores and processes data across four primary dimensions to provide a holistic view of the water ecosystem:

| Entity | Description |
| :--- | :--- |
| **User** | Management of credentials, notification settings, and ownership. |
| **Tank** | Technical specs (dimensions, capacity, and material) for accurate volume calculation. |
| **Water Level** | Time-series data tracking volume fluctuations over time. |
| **Quality** | Sensor data regarding the chemical and physical state of the water. |

---

## System Logic

The system doesn't just collect data; it analyzes it. By establishing a **baseline of normal consumption**, Merryweather can trigger alerts when deviations occur.

> **Note:** The anomaly detection algorithm uses historical data to differentiate between a "heavy laundry day" and a "burst pipe event."

---

## Getting Started

### Prerequisites
* Hardware: Compatible ultrasonic/pressure sensor + Microcontroller (ESP32/Arduino).
* Connectivity: Wi-Fi or LoRaWAN for data transmission.