import pandas as pd
import matplotlib.pyplot as plt
from sqlalchemy import create_engine
from statsmodels.tsa.statespace.sarimax import SARIMAX
import numpy as np

engine = create_engine('mysql+pymysql://root@localhost:3306/solane_capstone')

query = """
    SELECT created_at, amount
    FROM incomes
    WHERE created_at IS NOT NULL
    ORDER BY created_at;
"""

df = pd.read_sql(query, engine)

df['created_at'] = pd.to_datetime(df['created_at'])
df.set_index('created_at', inplace=True)

df_monthly = df.resample('ME').sum()

df_monthly['amount'].plot(figsize=(10, 6))
plt.title('Monthly Sales Income')
plt.xlabel('Date')
plt.ylabel('Amount')
plt.show()

model_sarima = SARIMAX(df_monthly['amount'],
                       order=(2, 1, 2),
                       seasonal_order=(1, 1, 1, 12))
model_sarima_fit = model_sarima.fit()

forecast_sarima = model_sarima_fit.forecast(steps=12)

forecast_dates = pd.date_range(
    start=f'{df_monthly.index[-1].year + 1}-01-01',
    periods=12,
    freq='M'
)

forecast_df_sarima = pd.DataFrame({
    'created_at': forecast_dates,
    'amount': forecast_sarima
})

forecast_df_sarima.to_sql('incomes_predictions', con=engine, if_exists='append', index=False)

for i, f in enumerate(forecast_sarima, start=1):
    predicted_month = forecast_dates[i - 1].strftime('%B %Y')
    print(f"Predicted sales income for {predicted_month}: ${f:.2f}")
