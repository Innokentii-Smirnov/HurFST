import sys
from os import path
import pandas as pd
COLUMNS = ['transcription', 'segmentation', 'translation', 'morph_tag', 'pos']
directory = sys.argv[1]
assert path.exists(directory), 'The output directory does not exist'
selected_columns = sys.argv[2:4]
words = pd.read_csv('data/words.csv', names=COLUMNS, keep_default_na=False)
df = words.loc[:, selected_columns]
print(len(df))
df.drop_duplicates(selected_columns, inplace=True)
print(len(df))
print(df.head())
input_column, output_column = selected_columns
grouped = df.groupby(input_column).agg({output_column: lambda values: ', '.join(sorted(values))})
print(len(grouped))
print(grouped.head())
grouped.to_csv(path.join(directory, 'input.txt'), sep='\t', columns=[], header=False)
grouped.to_csv(path.join(directory, 'corr.txt'), sep='\t', header=False, index=False)
