# CouponX Backend: Technical Specification & Architecture

This document serves as the master specification and implementation guide for the CouponX "Very Strong" Backend.

## 🏗️ Core Architecture
- **Framework**: Laravel 11.x (PHP 8.2+)
- **Pattern**: Service-Layer Architecture.
- **Security First**: Middleware-driven security layers (Fingerprinting, Banning, Rate Limiting).
- **Concurrency Control**: Database-level locking (`lockForUpdate`) for financial integrity.

## 🔒 Security Layers
1. **Device Fingerprinting**: Tracks device signals via custom headers.
2. **Access Control**: Strict Banning and Verified-only middleware.
3. **Financial Integrity**: Atomic transactions and AES-256 encryption for coupon codes.
4. **Anti-Fraud**: Automated suspension for reported users and reporter abuse detection (>5 reports).

## 💰 Coin System
- **Atomic Credits**: Guaranteed balance integrity.
- **Revenue sharing**: Automated platform/seller splits.
- **Grace Period**: Mandatory 1-hour delay before reveal.

## 📊 Administration
- **Dashboard API**: Real-time stats and moderation tools.
- **Audit Logs**: Full history of admin and sensitive user actions.

## 🚀 API Design
- **Proximity Search**: Haversine distance for local discovery.
- **Versioned API**: Scalable API v1 structure.
