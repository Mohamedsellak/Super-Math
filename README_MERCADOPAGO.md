# Super Math - MercadoPago Payment Integration

## 📋 Overview

This Laravel application integrates MercadoPago payment processing for credit purchases. Users can buy credits with flexible expiry periods and enjoy discounted pricing for longer durations.

## 🚀 Features

- ✅ **MercadoPago Integration** - Complete payment processing
- ✅ **Credit System** - Buy and manage credits with expiry dates
- ✅ **Dynamic Pricing** - Volume and duration discounts
- ✅ **Payment History** - Complete transaction tracking
- ✅ **Duplicate Prevention** - Secure payment processing
- ✅ **Multi-Environment** - Development and production ready

## 🛠️ Technical Stack

- **Framework**: Laravel 12.19.3
- **PHP Version**: 8.2.24
- **Payment Gateway**: MercadoPago SDK v3.5
- **Database**: MySQL
- **Currency**: Argentine Peso (ARS)

## 📦 Installation & Setup

### 1. Clone and Install Dependencies

```bash
git clone <repository-url>
cd Super-Math
composer install
npm install
```

### 2. Environment Configuration

Copy the environment file and configure:

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup

```bash
php artisan migrate
php artisan db:seed
```

## 💳 MercadoPago Configuration

### Development Setup

Add these variables to your `.env` file:

```env
# MercadoPago Test Credentials
MERCADOPAGO_ACCESS_TOKEN=TEST-7718145674287696-072014-a29a4213b96189f6d0e6d6881f133c91-166857479
MERCADOPAGO_PUBLIC_KEY=TEST-e4ff4445-6a64-4c9f-b3f3-4cd9505f5175
MERCADOPAGO_CLIENT_ID=166857479
MERCADOPAGO_CLIENT_SECRET=your-test-client-secret
MERCADOPAGO_WEBHOOK_SECRET=test_webhook_secret
MERCADOPAGO_SANDBOX=true

# Application URL
APP_URL=http://127.0.0.1:8000
```

### Production Setup

For production, update to your live credentials:

```env
# MercadoPago Production Credentials
MERCADOPAGO_ACCESS_TOKEN=APP_USR-your-production-access-token
MERCADOPAGO_PUBLIC_KEY=APP_USR-your-production-public-key
MERCADOPAGO_CLIENT_ID=your-production-client-id
MERCADOPAGO_CLIENT_SECRET=your-production-client-secret
MERCADOPAGO_WEBHOOK_SECRET=your-production-webhook-secret
MERCADOPAGO_SANDBOX=false

# Production URL (MUST be HTTPS)
APP_URL=https://yourdomain.com
```

## 🏗️ Architecture

### Key Components

1. **MercadoPagoService** (`app/Services/MercadoPagoService.php`)
   - Handles payment preference creation
   - Calculates pricing with discounts
   - Processes successful payments

2. **CreditController** (`app/Http/Controllers/User/CreditController.php`)
   - Manages credit purchase flow
   - Handles payment callbacks
   - Processes user credit updates

3. **Credit History System**
   - Tracks all credit transactions
   - Prevents duplicate payments
   - Maintains audit trail

### Database Schema

#### Users Table
```sql
- id: Primary key
- credit: Integer (user's current credit balance)
- credit_expires_at: Timestamp (when credits expire)
- first_name, last_name, email: User details
```

#### Credit Histories Table
```sql
- id: Primary key
- user_id: Foreign key to users
- amount: String (credit change amount)
- action: String (Payment, Download, Expired)
- description: Text (transaction details)
- created_at: Timestamp
```

## 💰 Pricing Structure

### Current Test Pricing
- **Base Rate**: 1 ARS per credit
- **Volume Discounts**:
  - 1 month: 100% (no discount)
  - 2-3 months: 5% discount
  - 4-6 months: 10% discount
  - 7-9 months: 15% discount
  - 10+ months: 20% discount

### Production Pricing Setup

Update the pricing in `app/Services/MercadoPagoService.php`:

```php
public function calculatePrice(int $creditAmount, int $months): float
{
    // Change this value for production
    $pricePerCredit = 50; // ARS per credit (adjust as needed)
    
    // Discount structure remains the same
    $monthlyMultiplier = match($months) {
        1 => 1.0,
        2, 3 => 0.95,
        4, 5, 6 => 0.90,
        7, 8, 9 => 0.85,
        default => 0.80,
    };

    return max(round($creditAmount * $pricePerCredit * $monthlyMultiplier, 2), 1.0);
}
```

## 🔄 Payment Flow

### 1. User Journey
```
Purchase Page → Select Credits → MercadoPago Checkout → Payment → Credits Added
```

### 2. Technical Flow
```
Form Submission → createPayment() → MercadoPago API → User Payment → Callback → processSuccessfulPayment()
```

### 3. Callback URLs
- **Success**: `/dashboard/credits/payment/success`
- **Failure**: `/dashboard/credits/payment/failure`
- **Pending**: `/dashboard/credits/payment/pending`

## 🧪 Testing

### Official MercadoPago Test Cards

**✅ APPROVED Payments:**
```
Mastercard: 5031 4332 1540 6351
Visa: 4235 6477 2802 5682
American Express: 3753 651535 56885
Elo (Debit): 5067 7667 8388 8311

Expiry: 11/30
Security Code: 123 (1234 for Amex)
Cardholder Name: APRO (CRITICAL - this controls approval)
```

**❌ REJECTED Payments:**
```
Use same card numbers above, but change cardholder name:
- OTHE: General error (declined)
- FUND: Insufficient funds
- SECU: Invalid security code
- EXPI: Invalid expiry date
- FORM: Form error
- CARD: Missing card number
```

**⏳ PENDING Payments:**
```
Use same card numbers with:
Cardholder Name: CONT
```

### Important: Cardholder Name Controls Payment Result

| Cardholder Name | Result | Description |
|-----------------|---------|-------------|
| **APRO** | ✅ Approved | Payment successful |
| **OTHE** | ❌ Declined | General error |
| **CONT** | ⏳ Pending | Payment pending |
| **CALL** | ❌ Declined | Validation required |
| **FUND** | ❌ Declined | Insufficient funds |
| **SECU** | ❌ Declined | Invalid security code |
| **EXPI** | ❌ Declined | Invalid expiry date |

### Testing Steps

1. **Go to credit purchase page**
2. **Select any credit amount**
3. **At MercadoPago checkout, use:**
   - Card: `5031 4332 1540 6351` (Mastercard)
   - Expiry: `11/30`
   - Security Code: `123`
   - **Cardholder Name: `APRO`** (for success)
4. **Complete payment**
5. **Verify credits are added to your account**

### Manual Testing

Test payment callbacks manually:

```bash
# Success callback
curl "http://127.0.0.1:8000/dashboard/credits/payment/success?payment_id=test123&status=approved&external_reference=2_100_5_1674392847"

# Failure callback
curl "http://127.0.0.1:8000/dashboard/credits/payment/failure"

# Pending callback
curl "http://127.0.0.1:8000/dashboard/credits/payment/pending"
```

## 🚀 Deployment

### Production Checklist

- [ ] **SSL Certificate** - Install and configure HTTPS
- [ ] **Environment Variables** - Update to production credentials
- [ ] **Sandbox Mode** - Set `MERCADOPAGO_SANDBOX=false`
- [ ] **Domain Configuration** - Update `APP_URL` to production domain
- [ ] **Pricing** - Adjust `$pricePerCredit` for real prices
- [ ] **Database Migration** - Run on production database
- [ ] **Error Monitoring** - Set up logging and monitoring

### Environment-Based Features

The application automatically handles:
- **Development**: No back URLs (localhost limitation)
- **Production**: Automatic back URLs when sandbox is disabled
- **Ngrok Support**: Set `NGROK_URL` environment variable for testing

### Back URLs Configuration

The system automatically determines when to include back URLs:

```php
// Back URLs are included when:
// 1. NOT in local environment, OR
// 2. NGROK_URL is set, OR  
// 3. Sandbox mode is disabled (production)

if (!app()->environment('local') || env('NGROK_URL') || !config('services.mercadopago.sandbox')) {
    // Include back URLs for payment callbacks
}
```

## 🔒 Security Features

### Payment Security
- **User Verification** - Ensures authenticated user owns the payment
- **Duplicate Prevention** - Prevents processing the same payment twice
- **External Reference** - Unique identifier for each transaction
- **Payment Validation** - Verifies payment status and amount

### Data Protection
- **Environment Variables** - Sensitive credentials stored securely
- **Logging** - Comprehensive audit trail without exposing secrets
- **Error Handling** - Graceful failure handling with proper error messages

## 📊 Monitoring & Logging

### Key Log Events
```bash
# View payment logs
tail -f storage/logs/laravel.log | grep -i mercadopago

# View specific events
grep "Payment.*callback" storage/logs/laravel.log
grep "MercadoPago preference created" storage/logs/laravel.log
```

### Important Metrics to Monitor
- Payment success/failure rates
- Average transaction amounts
- User credit balances
- Payment processing times
- Error frequencies

## 🆘 Troubleshooting

### Common Issues

**1. Route Not Found Error**
```
Route [credits.index] not defined
```
**Solution**: Check route names match in controller redirects

**2. MercadoPago API Errors**
```
Api error. Check response for details
```
**Solution**: Verify credentials and check logs for specific error messages

**3. Back URLs Not Working**
**Solution**: Ensure production environment or set `NGROK_URL` for testing

**4. Card Rejection - "Your card refused payment"**
```
Error: Operation refused by card
```
**Solution**: 
- Use official MercadoPago test cards: `5031 4332 1540 6351`
- **CRITICAL**: Set cardholder name to `APRO` for approval
- Verify expiry date is `11/30` and security code is `123`

**5. Zero Price Error**
```
unit_price cannot be 0.0
```
**Solution**: Check price calculation logic and ensure minimum price

### Debug Commands

```bash
# Check routes
php artisan route:list | grep credit

# Check configuration
php artisan config:show services.mercadopago

# Clear cache
php artisan config:clear
php artisan cache:clear

# Check logs
tail -f storage/logs/laravel.log
```

## 📝 API Documentation

### MercadoPagoService Methods

#### `createCreditPurchasePreference(User $user, int $creditAmount, int $months, float $price)`
Creates a payment preference with MercadoPago.

#### `calculatePrice(int $creditAmount, int $months)`
Calculates the final price with volume and duration discounts.

#### `processSuccessfulPayment(User $user, string $paymentId, int $creditAmount, int $months, float $paidAmount)`
Processes successful payment and updates user credits.

### Controller Endpoints

- `GET /dashboard/credits` - Credit history page
- `GET /dashboard/credits/purchase` - Purchase credits page  
- `POST /dashboard/credits/create-payment` - Create payment preference
- `GET /dashboard/credits/payment/success` - Payment success callback
- `GET /dashboard/credits/payment/failure` - Payment failure callback
- `GET /dashboard/credits/payment/pending` - Payment pending callback

## 🤝 Support

### Development Team Contacts
- **Technical Lead**: [Your contact info]
- **DevOps**: [DevOps contact info]

### MercadoPago Resources
- [Developer Documentation](https://www.mercadopago.com.ar/developers)
- [SDK Documentation](https://github.com/mercadopago/sdk-php)
- [Testing Guide](https://www.mercadopago.com.ar/developers/en/docs/your-integrations/test)

---

**Last Updated**: July 22, 2025
**Version**: 1.0.0
**Environment**: Production Ready
